import isFunction from '../utils/isFunction';

export default function (Alpine) {
    Alpine.directive('accordion', (el, directive) => {
        if (! directive.value) {
            handleRoot(el, Alpine);
        } else if (directive.value === 'button') {
            handleButton(el, Alpine);
        } else if (directive.value === 'panel') {
            handlePanel(el, Alpine);
        } else if (directive.value === 'group') {
            handleGroup(el, Alpine);
        }
    }).before('bind');

    Alpine.magic('accordion', el => {
        let data = Alpine.$data(el);

        return {
            get isOpen() { return data.__isSelected },
            get isDisabled() { return data.__isDisabled },
            close() { data.__close() },
            open() { data.__open() },
            toggle() { data.__toggle() },
        };
    });

    Alpine.magic('accordionGroup', el => {
        let data = Alpine.$data(el);

        return {
            selectPanel(panelEl) {
                if (typeof panelEl !== 'object') {
                    return data.__selectPanel(panelEl);
                }

                // If we receive an HTMLElement, we need to find the panel object on it.
                if (panelEl instanceof HTMLElement) {
                    let $data = Alpine.$data(panelEl);

                    $data.__panelEl && data.__selectPanel($data.__panelEl);

                    return;
                }

                data.__selectPanel(panelEl);
            },
            closeAll() { data.__closeAll() },
            openAll() { data.__openAll() },
        };
    });
}

function handleRoot(el, Alpine) {
    Alpine.bind(el, {
        'x-modelable': '$data.__isOpen',
        'x-data'() {
            return {
                __isOpen: false,
                __id: undefined,
                __panelEl: undefined,
                __isDisabled: false,

                init() {
                    this.__id = Alpine.bound(this.$el, 'id') ?? this.$id('blade-accordion');

                    const defaultIsOpen = Boolean(Alpine.bound(this.$el, 'default-open', false));
                    this.__panelEl = this.$el;
                    this.__panelEl.__disabled = Alpine.bound(this.$el, 'disabled', false);
                    this.__isDisabled = this.__panelEl.__disabled;

                    this.__panelEl.__id = this.__id;

                    if (defaultIsOpen) {
                        this.__isOpen = true;
                    }

                    if (isFunction(this.$data.__addPanel)) {
                        this.$data.__addPanel(this.$el);
                    }

                    if (this.__isOpen && isFunction(this.$data.__selectPanel) && this.__shouldSelectOnInit()) {
                        this.$data.__selectPanel(this.$el);
                    }

                    queueMicrotask(() => {
                        this.__panelEl.__button = this.$el.querySelector(`#${this.$data.$id('blade-accordion-button')}`);

                        // We need to watch for certain DOM changes to correctly keep track of the current state.
                        const observer = new MutationObserver(mutations => {
                            mutations.forEach(mutation => {
                                if (mutation.attributeName === 'disabled') {
                                    this.__panelEl.__disabled = this.$el.hasAttribute('disabled');
                                    this.__isDisabled = this.__panelEl.__disabled;
                                }
                            });
                        });

                        observer.observe(this.$el, { attributes: true });

                        if (isFunction(this.$data.__selectPanel)) {
                            queueMicrotask(() => {
                                this.$watch('__isOpen', () => {
                                    // We need to let our accordion group parent know that the value was
                                    // changed externally, usually via x-model.
                                    if (this.__isOpen !== this.__isSelected) {
                                        this.$data.__selectPanel(this.$el);
                                    }
                                });
                            });
                        }
                    });
                },

                destroy() {
                    if (isFunction(this.$data.__destroyPanel)) {
                        this.$data.__destroyPanel(this.$el);
                    }
                },

                __shouldSelectOnInit() {
                    if (this.$data.__multiple) {
                        return true;
                    }

                    return this.$data.__active === undefined;
                },

                get __isSelected() {
                    // If we are in a panel group, we need to check the group's active panel.
                    if (isFunction(this.$data.__isSelectedPanel)) {
                        return this.$data.__isSelectedPanel(this.__panelEl);
                    }

                    return this.__isOpen;
                },

                __close() {
                    if (this.__isDisabled) {
                        return;
                    }

                    this.__isOpen = false;

                    if (isFunction(this.$data.__selectPanel)) {
                        this.$data.__selectPanel(
                            this.$data.__multiple ? this.__panelEl : null
                        );
                    }
                },

                __open() {
                    if (this.__isDisabled) {
                        return;
                    }

                    this.__isOpen = true;

                    if (isFunction(this.$data.__selectPanel)) {
                        this.$data.__selectPanel(this.__panelEl);
                    }
                },

                __toggle() {
                    if (this.__isDisabled) {
                        return;
                    }

                    this.__isOpen = ! this.__isOpen;

                    if (isFunction(this.$data.__selectPanel)) {
                        this.$data.__selectPanel(this.__panelEl);
                    }
                },
            };
        },
        'x-id'() { return ['blade-accordion-panel', 'blade-accordion-button'] },
    });
}

function handleGroup(el, Alpine) {
    Alpine.bind(el, {
        'x-data'() {
            return {
                __active: undefined,
                __ready: false,

                // __multiple allows us to have multiple panels open at once.
                __multiple: false,
                __panels: [],

                init() {
                    this.__multiple = Boolean(Alpine.bound(this.$el, 'multiple', false));

                    if (this.__multiple && this.__active === undefined) {
                        this.__active = [];
                    }

                    queueMicrotask(() => {
                        // Let our component know it's able to dispatch events.
                        this.__ready = true;
                    });
                },

                __enabledPanels() {
                    return this.__panels.filter(panel => panel.isConnected && ! panel.__disabled);
                },

                __addPanel(el) {
                    this.__panels.push(el);

                    // Remove any panels that are no longer connected to the DOM.
                    this.__panels = this.__panels.filter(panel => panel.isConnected);
                },

                __destroyPanel(el) {
                    this.__panels.splice(this.__panels.indexOf(el), 1);

                    if (! this.__multiple && this.__panels.length === 0) {
                        this.__active = undefined;
                    }
                },

                __selectPanel(el) {
                    const id = typeof el === 'object'
                        ? el.__id
                        : el;

                    if (this.__multiple) {
                        if (this.__active.includes(id)) {
                            this.__dispatchEvent('accordion-close', { id });

                            return this.__active.splice(this.__active.indexOf(id), 1);
                        }

                        this.__dispatchEvent('accordion-open', { id });

                        return this.__active.push(id);
                    }

                    const isClosing = this.__active === id;
                    this.__active = isClosing
                        ? null
                        : id;

                    this.__dispatchEvent(isClosing ? 'accordion-close' : 'accordion-open', { id });
                },

                __isSelectedPanel(el) {
                    if (this.__multiple) {
                        return this.__active.includes(el.__id);
                    }

                    return this.__active === el.__id;
                },

                __closeAll() {
                    this.__dispatchEvent('accordion-close-all')

                    if (this.__multiple) {
                        return this.__active = [];
                    }

                    this.__active = null;
                },

                __openAll() {
                    this.__enabledPanels().forEach(panel => {
                        if (this.__multiple) {
                            ! this.__active.includes(panel.__id) && this.__active.push(panel.__id);

                            return;
                        }

                        this.__active = panel.__id;
                    });

                    this.__dispatchEvent('accordion-open-all');
                },

                __dispatchEvent(name, detail = {}) {
                    this.__ready && this.$dispatch(name, detail);
                },

                // Handle keyboard navigation.
                __focusNext(panelEl) {
                    const enabledPanels = this.__enabledPanels();
                    const currentIndex = enabledPanels.indexOf(panelEl);
                    let nextIndex = (currentIndex + 1) >= enabledPanels.length
                        ? 0
                        : currentIndex + 1;

                    this.__focusPanel(enabledPanels, nextIndex);
                },

                __focusPrev(panelEl) {
                    const enabledPanels = this.__enabledPanels();
                    const currentIndex = enabledPanels.indexOf(panelEl);
                    let prevIndex = (currentIndex - 1) < 0
                        ? enabledPanels.length - 1
                        : currentIndex - 1;

                    this.__focusPanel(enabledPanels, prevIndex);
                },

                __focusFirst() {
                    this.__focusPanel(this.__enabledPanels(), 0);
                },

                __focusLast() {
                    const enabledPanels = this.__enabledPanels();
                    this.__focusPanel(enabledPanels, enabledPanels.length - 1);
                },

                __focusPanel(panels, index) {
                    const panel = panels[index];

                    panel?.__button && panel.__button.focus();
                },
            };
        },
    });
}

function handleButton(el, Alpine) {
    Alpine.bind(el, {
        'x-init'() {
            if (this.$el.tagName.toLowerCase() === 'button' && ! this.$el.hasAttribute('type')) {
                this.$el.type = 'button';
            } else if (this.$el.tagName.toLowerCase() !== 'button' && ! this.$el.hasAttribute('role')) {
                this.$el.setAttribute('role', 'button');
            }
        },
        ':tabindex'() {
            if (this.$el.tagName.toLowerCase() === 'button') {
                return null;
            }

            return this.$data.__isDisabled ? null : 0;
        },
        // We give an ID here because we can't rely on x-refs because of how the component is structured.
        ':id'() { return this.$data.$id('blade-accordion-button') },
        '@click'() { this.$data.__toggle() },
        ':aria-expanded'() { return this.$data.__isSelected },
        ':aria-controls'() { return this.$data.$id('blade-accordion-panel') },
        ':disabled'() { return this.$data.__isDisabled },
        '@keydown.space.prevent.stop'() { this.$data.__toggle() },
        '@keydown.enter.prevent.stop'() { this.$data.__toggle() },
        '@keydown.arrow-down'(e) {
            // We only need to handle this when in a group.
            if (isFunction(this.$data.__focusNext)) {
                e.preventDefault();
                e.stopPropagation();

                return this.$data.__focusNext(this.$data.__panelEl);
            }
        },
        '@keydown.arrow-up'(e) {
            // We only need to handle this when in a group.
            if (isFunction(this.$data.__focusPrev)) {
                e.preventDefault();
                e.stopPropagation();

                return this.$data.__focusPrev(this.$data.__panelEl);
            }
        },
        '@keydown.home'(e) {
            // We only need to handle this when in a group.
            if (isFunction(this.$data.__focusFirst)) {
                e.preventDefault();
                e.stopPropagation();

                return this.$data.__focusFirst();
            }
        },
        '@keydown.end'(e) {
            // We only need to handle this when in a group.
            if (isFunction(this.$data.__focusLast)) {
                e.preventDefault();
                e.stopPropagation();

                return this.$data.__focusLast();
            }
        },
        // Required for firefox, event.preventDefault() in handleKeyDown for
        // the Space key doesn't cancel the handleKeyUp, which in turn
        // triggers a *click*.
        '@keyup.space.prevent'() {},
    });
}

function handlePanel(el, Alpine) {
    Alpine.bind(el, {
        'x-show'() {
            return this.$accordion.isOpen;
        },
        'x-init'() {
            // Handle an edge case where the panel is supposed to be initially open, but x-collapse is not allowing it to be shown.
            // This usually happens when dynamically adding panels to the DOM in livewire.
            if (this.$accordion.isOpen && this.$el.hasAttribute('x-collapse') && this.$el.hasAttribute('hidden')) {
                this.$el.removeAttribute('hidden');
                this.$el.style.height = 'auto';
                this.$el.style.overflow = null;
            }
        },
        ':id'() {
            return this.$data.$id('blade-accordion-panel');
        },
    });
}

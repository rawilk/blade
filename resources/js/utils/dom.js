export const isElement = el => !!(el && el.nodeType === Node.ELEMENT_NODE);

export const isTag = (el, tag) => isElement(el) && el.tagName.toLowerCase() === tag.toLowerCase();

export const hasAttr = (el, attr) => (attr && isElement(el) ? el.hasAttribute(attr) : null);

export const setAttr = (el, attribute, value) => {
    if (attribute && isElement(el)) {
        el.setAttribute(attribute, value);
    }
}

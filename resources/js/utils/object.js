/**
 * Quick object check.
 * This is primarily used to tell Objects from primitive values
 * when we know the value is a JSON-compliant type.
 *
 * Note: object could be a complex type like array, Date, etc.
 */
export const isObject = value => value !== null && typeof value === 'object';

function toVuelidateField(field) {
    return `this.$v.${field}`;
}

export const vuelidateField = (field) => {
    field = toVuelidateField(field);
    const evalCode = `${field}.$dirty ? !${field}.$invalid : null`;
    return eval(evalCode);
}

export const touchVuelidateField = (field) => {
    field = toVuelidateField(field);
    const evalCode = `${field}.$touch()`;
    eval(evalCode);
}
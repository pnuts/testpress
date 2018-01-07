Storage.prototype.setObject = function (key, value, salt) {
    let data;
    if(value instanceof Set) {
        data = {
            type: 'Set',
            value: Array.from(value)
        };
    } else if(value instanceof Map) {
        let pairs = {};
        value.forEach((v, k) => {pairs[k] = v; });
        data = {
            type: 'Map',
            value: pairs
        };
    } else {
        data = {
            type: 'Default',
            value: value
        };
    }

    let item = JSON.stringify(data);
    if(salt !== undefined) {
        item = CryptoJS.AES.encrypt(item, salt).toLocaleString();
    }
    this.setItem(key, item);
};

Storage.prototype.getObject = function (key, defaultValue = null, salt) {
    let item = this.getItem(key);
    if (item === null) {
        return defaultValue;
    }
    try {
        if(salt !== undefined) {
            item = CryptoJS.AES.decrypt(item, salt).toString(CryptoJS.enc.Utf8);
        }
        let data = JSON.parse(item);
        switch (data.type) {
            case 'Set':
                return new Set(data.value);
            case 'Map':
                let ret = new Map();
                for(let k in data.value) {
                    ret.set(k, data.value[k]);
                }
                return ret;
            default:
                return data.value;
        }
    } catch (e) {
        return defaultValue;
    }
};
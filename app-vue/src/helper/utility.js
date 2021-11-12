export const appConfig = {
    base_title: "AirPrice",
    base_administration: "/administration",
}

export function setTitle(title = "", use_base = true) {
    if (use_base) {
        let baseTitle = appConfig.base_title;
        title = title.length ? `${baseTitle} - ${title}` : baseTitle;
    }
    document.title = title;
};

export function getStorageData(data, type_storage = null, type = "String") {
    let data_storage
    switch (type_storage === null ? null : type_storage.toLowerCase()) {
        case null:
            data_storage = window.localStorage.getItem(data) !== null ? window.localStorage.getItem(data) : window.sessionStorage.getItem(data);
            break
        case 'local':
            data_storage = window.localStorage.getItem(data);
            break
        case 'session':
            data_storage = window.sessionStorage.getItem(data);
            break
    }

    switch (type) {
        case 'String':
            return data_storage === null ? "" : data_storage + "";
        case 'Boolean':
            return !!(data_storage * 1);
        case 'Number':
            return data_storage * 1;
        case 'Integer':
            return parseInt(data_storage);
        case 'Float':
            return parseFloat(data_storage);
        case 'JSON':
            try {
                return JSON.parse(data_storage);
            } catch (e) {
                return function () {
                    return 'invalid';
                }
            }
    }
};

export function setStorageData(key, value, type_storage = 'local') {
    switch (type_storage.toLowerCase()) {
        case 'local':
            window.localStorage.setItem(key, value);
            return true;
        case 'session':
            window.sessionStorage.setItem(key, value);
            return true;
    }
    return false;
}

export function debounce(fn, delay) {
    let timeoutID = null;
    return function () {
        clearTimeout(timeoutID)
        const args = arguments;
        const that = this;
        timeoutID = setTimeout(function () {
            fn.apply(that, args)
        }, delay)
    }
}

export async function apiFetch(pathReq, init = {}, callback_done = null, catch_status = null, catch_fail = null) {
    let res = {};
    try {
        res = await fetch(pathReq, init)
    } catch (e) {
        catch_fail(e);
    }
    try {
        if (res.ok) {
            const data = await res.json();
            if (callback_done !== null) {
                callback_done(data);
            }
        } else {
            if (catch_status !== null) {
                catch_status(res);
            }

        }
    } catch (e) {
        if (catch_status !== null) {
            catch_status(res);
        }
    }
};


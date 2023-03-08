class Datos {
    constructor(id, client, precinte, url, date) {
        this._id = id;
        this._client = client;
        this._precinte = precinte;
        this._url = url;
        this._date = date;
    }
    get id() {
        return this._id;
    }
    set id(id) {
        this._id = id;
    }
    get precinte() {
        return this._precinte;
    }
    set precinte(precinte) {
        this._precinte = precinte;
    }
    get url() {
        return this._url = url;
    }
    get client() {
        return this._client;
    }
    set client(client) {
        this._client = client;
    }
    get date() {
        return this._date = date;
    }
    set date(date) {
        this._date = date;
    }
}

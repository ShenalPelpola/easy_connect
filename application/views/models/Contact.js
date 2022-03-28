// Model for the Contact
var Contact = Backbone.Model.extend({
    defaults: {
        first_name: null,
        last_name: null,
        email: null,
        telephone: null,
        address: null,
        favorite: false,
        notes: null,
        avatar: null,
        created_date: null,
        tags: null,
        favorite: null
    },
    idAttribute: "id",

    // this method call the url based on the Request method type
    getCustomUrl: function (method) {
        switch (method) {
            case 'read':
                return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts/contact";
                break;
            case 'create':
                return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts";
                break;
            case 'update':
                return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts/contact";
                break;
            case 'delete':
                return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts/contact/" + this.get("id");
                break;
        }
    },
    sync: function (method, model, options) {
        options || (options = {});
        options.url = this.getCustomUrl(method.toLowerCase());
        return Backbone.sync.apply(this, arguments);
    }
})

// initial collection for the contact list
var Contacts = Backbone.Collection.extend({
    model: Contact,
    url: function () {
        return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts";
    },
})

// collection for the searchContact list
var SearchContacts = Backbone.Collection.extend({
    model: Contact,
    url: function () {
        return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts/search";
    },
})

//collection for the favorited contact list
var FavoritedContacts = Backbone.Collection.extend({
    model: Contact,
    url: function () {
        return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts/favorites";
    },
})

// collection for the recentcontact list.
var RecentContacts = Backbone.Collection.extend({
    model: Contact,
    url: function () {
        return "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/api/contacts/recent";
    },
})
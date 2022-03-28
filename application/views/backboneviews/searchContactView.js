var SearchContactsView = Backbone.View.extend({
    model: searchContacts,
    el: "#searchContactForm",
    initialize: function () { },
    render: function () {
        return this;
    },
    events: {
        "click #search-submit": 'searchContacts'
    },
    searchContacts: function (e) {
        e.preventDefault(e);
        var id = $("#td-contact-id").text();
        var email = $("#search-email").val();
        var telephone = $("#search-telephone").val();
        var first_name = $("#search-first-name").val();
        var last_name = $("#search-last-name").val();
        var address = $("#search-address").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var tags = [];
        $('.search-tags:checked').each(function (i) {
            tags[i] = $(this).val();
        });

        searchContacts.fetch({
            async: false,
            type: "POST",
            data: {
                id,
                email,
                telephone,
                first_name,
                last_name,
                address,
                tags,
                startDate,
                endDate
            },
        })

        if (searchContacts.length == 0) {
            contacts.each((c) => {
                contacts.remove(c);
            })
            contacts.remove(contacts.models[0]);
        } else {
            contacts.reset();
            searchContacts.each(function (c) {
                contacts.add(c);
            })
        }
    }
});


// initialize a new searchContactView object
var searchContactsView = new SearchContactsView();
var RecentContactListView = Backbone.View.extend({
    model: recentContacts,
    el: $("#contact-list-container"),
    initialize: function () {
        // fetch the recent contact from the endpoint
        recentContacts.fetch({
            async: false,
        })
        this.render();
    },
    render: function () {
        var self = this;
        // iterate through the contacts collection and construct the html to display
        recentContacts.each(function (c) {
            var favorite = c.get("favorite") == true ? "Yes" : "NO";
            var firstname = c.get("first_name") == null ? "-" : c.get("first_name");
            var lastName = c.get("last_name") == null ? "-" : c.get("last_name");
            var email = c.get("email") == null ? "-" : c.get("email");
            var telephone = c.get("telephone") == null ? "-" : c.get("telephone");
            var avatar = c.get("avatar") == "" ? "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/assets/img/default-contact-2.png" : c.get("avatar");
            var address = c.get("address") == null ? "-" : c.get("address");
            var created_date = c.get("created_date") == null ? "-" : c.get("created_date");
            var contactItem =
                `<tr>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="${avatar}" alt="" style="width: 75px; height: 75px" class="rounded-circle"/>
                                    <div class="ms-4 table-content">
                                    <a href="https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/contacts/details?contact_id=${c.get("id")}">
                                        <p class="fw-bold mb-1">${firstname + " " + lastName}</p>
                                    </a>
                                    </div>
                                </div>
                            </td>
                            <td> <p class="mb-0  table-content">${email}</p> </td>
                            <td> <p class="mb-0 table-content">${telephone}</p> </td>
                            <td> <span class="table-content">${address}</span> </td>
                            <td> <span class="table-content">${favorite}</span> </td>
                            <td> <span class="table-content">${created_date}</span></td>
                        </tr>`;

            self.$el.append(contactItem);
        })
    }
});
var recentContactListView = new RecentContactListView();
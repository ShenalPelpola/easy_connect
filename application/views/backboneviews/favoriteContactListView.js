var FavoriteContactListView = Backbone.View.extend({
    model: favoriteContacts,
    el: $("#contact-list-container"),
    initialize: function () {
        favoriteContacts.fetch({
            async: false,
        })
        this.listenTo(favoriteContacts, 'add remove', this.render);
        this.render();
    },
    render: function () {
        var self = this;
        // remove duplications
        self.$el.empty();
        // iterate through the contacts collection and construct the html to display
        favoriteContacts.each(function (c) {
            var favorite = c.get("favorite") == true ? "Yes" : "NO";
            var firstname = c.get("first_name") == null ? "-" : c.get("first_name");
            var lastName = c.get("last_name") == null ? "-" : c.get("last_name");
            var email = c.get("email") == null ? "-" : c.get("email");
            var telephone = c.get("telephone") == null ? "-" : c.get("telephone");
            var avatar = c.get("avatar") == "" ? "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/assets/img/default-contact-2.png" : c.get("avatar");
            var address = c.get("address") == null ? "-" : c.get("address");
            var tags = c.get("tags");
            var displaytags = "";

            // render the tags
            if (tags.length > 0) {
                tags.forEach((tag) => {
                    displaytags += tag.category_name + ", ";
                });
            } else {
                displaytags = "-";
            }
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
                    <td> <span class="table-content">${displaytags}</span></td>
                </tr>`;

            self.$el.append(contactItem);
        })
    }
});
var favoriteContactListView = new FavoriteContactListView();
var ContactView = Backbone.View.extend({
    model: contact,
    el: $("#contact-view"),
    initialize: function () {
        contact.fetch({
            async: false,
            data: {
                contact_id: contactId
            }
        })
        this.listenTo(contact, 'add remove change', this.render);
        this.render();
    },
    render: function () {
        var self = this;
        self.$el.empty();
        var firstname = contact.get("first_name") == null ? "-" : contact.get("first_name");
        var lastName = contact.get("last_name") == null ? "-" : contact.get("last_name");
        var email = contact.get("email") == null ? "-" : contact.get("email");
        var telephone = contact.get("telephone") == null ? "-" : contact.get("telephone");
        var address = contact.get("address") == null ? "-" : contact.get("address");
        var notes = contact.get("notes");
        var avatar = contact.get("avatar") == null ? "-" : contact.get("avatar");
        var favorite = contact.get("favorite") == true ? true : false;
        var contactDetail =
            `
                    <div class="modal fade" id="deleteForm" aria-hidden="true" aria-labelledby="deleteFormToggleLabel" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Contact</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Are you sure you want to delete this contact?
                                    </p>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger ms-3" id="delete"> Confirm
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <h3 class="mb-4">${firstname + " " + lastName}</h3>
                    <div id="flashMessage">
                        Your changes have been saved!
                    </div>
                    <div class="alert alert-danger" role="alert" id="create-form-alert" style="display:none;">
                        A contact with the same email or telephone number already exists.
                    </div>
                    <form class="form row g-3 needs-validation" id="editform" novalidate>
                        <div class="col-md-6 mb-2 form-group">
                            <label for="email" class="custom-label">Email</label>
                            <input type="email" class="form-control has-validation" id="email" value='${email}' disabled="true" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <div class="col-md-6 mb-2 form-group">
                            <label for="telephone" class="custom-label">Telephone</label>
                            <input type="text" class="form-control has-validation" id="telephone" value='${telephone}' disabled="true" required>
                            <div class="invalid-feedback">Telephone number is required.</div>
                        </div>

                        <div class="col-md-6 mb-2 form-group">
                            <label for="first-name" class="custom-label">First name</label>
                            <input type="text" class="form-control has-validation" id="first-name" value='${firstname}' disabled="true" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>

                        <div class="col-md-6 mb-2 form-group">
                            <label for="last-name" class="custom-label">Last name</label>
                            <input type="text" class="form-control has-validation" id="last-name" value='${lastName}' disabled="true" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>

                        <div class="col-md-6 mb-2 form-group">
                            <label for="avatar" class="custom-label">Avatar</label>
                            <input type="text" class="form-control" id="avatar" value='${avatar}' disabled="true">
                        </div>

                        <div class="col-md-6 mb-2 form-group">
                            <label for="address" class="custom-label">Address</label>
                            <input type="text" class="form-control" id="address" value='${address}' disabled="true">
                        </div>

                        <div class="col-md-12 mb-2 form-group">
                            <label for="notes" class="custom-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="4" disabled="true">${notes}</textarea>
                        </div>

                        <label for="" class="form-label">Tags</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label" for="inlineCheckbox1">Family</label>
                                <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox1" value="1" disabled="true">
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineCheckbox2">Friend</label>
                                <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox2" value="2" disabled="true">
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineCheckbox3">Relative</label>
                                <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox3" value="3" disabled="true">
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineCheckbox3">Work-associate</label>
                                <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox4" value="4" disabled="true">
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineCheckbox3">Spouse</label>
                                <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox5" value="5" disabled="true">
                            </div>
                        </div>
                        <div>
               

                        <div class="form-check form-switch mt-3">
                        <label class="form-check-label" for="add-favorite">Add to favorites</label>
                            <input class="form-check-input" type="checkbox" id="add-favorite" ${favorite ? 'checked' : ''} disabled>
                        </div>

                        <div class="col-md-4 mt-5 form-group">
                            <button class="btn btn-success" id="edit">Edit</button>
                            <a class="btn btn-danger" data-bs-toggle="modal" href="#deleteForm" id="delete-popup-button" role="button">Delete</a>
                            <button type="submit" class="btn btn-success m-3" style="display:none" id="save-changes">Save Changes</button>
                        </div>

                    </form>`;
        self.$el.append(contactDetail);
        return this;
    },
    events: {
        "click #edit": 'activateForm',
        "click #save-changes": 'updateContact',
        "click #delete": 'deleteContact'
    },

    activateForm: function (e) {
        e.preventDefault();
        $("#editform input").removeAttr("disabled");
        $("#editform textarea").removeAttr("disabled");
        $('input[type=checkbox]').removeAttr('disabled');
        $("#delete-popup-button").css("display", "none");
        $("#save-changes").css("display", "inline-block");
        $("#edit").css("display", "none");
    },

    deleteContact: function () {
        contact.destroy({
            wait: true,
            success: function () {
                window.location.href = "https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/contacts/";
                window.location.replace("https://w1714945.users.ecs.westminster.ac.uk/easy_connect/index.php/contacts/");
                console.log("The model has been deleted to the server");
            },
            error: function () {
                console.log("Something went wrong while deleting the model");
            }
        });
    },

    updateContact: function (e) {
        e.preventDefault();
        $("#editform").addClass('was-validated');
        var email = $("#email").val();
        var telephone = $("#telephone").val();
        var first_name = $("#first-name").val();
        var last_name = $("#last-name").val();
        var address = $("#address").val();
        var avatar = $("#avatar").val();
        var notes = $("#notes").val();
        var favorite = $('#add-favorite').is(':checked');
        var tags = [];
        $('.create-tags:checked').each(function (i) {
            tags[i] = $(this).val();
        });

        // set contact with to be update details.
        if (email != "" && telephone != "" && first_name != "" && last_name != "") {
            contact.set("id", contactId);
            contact.set("email", email);
            contact.set("telephone", telephone);
            contact.set("first_name", first_name);
            contact.set("last_name", last_name);
            contact.set("address", address);
            contact.set("avatar", avatar);
            contact.set("tags", tags);
            contact.set("notes", notes);
            contact.set("favorite", favorite);

            contact.save({}, {
                wait: true,
                success: function (res) {
                    $('#flashMessage')
                        .hide()
                        .slideDown(1000)
                        .delay(3000)
                        .slideUp();
                    console.log("The model has been saved to the server");
                },
                error: function () {
                    $("#create-form-alert").css("display", "block");
                    console.log("Something went wrong while saving the model");
                }
            });
        }
    }
});

var contactView = new ContactView();
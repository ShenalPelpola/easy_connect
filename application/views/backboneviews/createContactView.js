var CreateContactView = Backbone.View.extend({
    el: "#createContactForm",
    model: contacts,
    initialize: function () {

    },
    render: function () {
        return this;
    },
    events: {
        "click #create": 'addContact'
    },
    addContact: function (e) {
        e.preventDefault();
        $("#createContactForm").addClass('was-validated');
        var email = $("#email").val();
        var telephone = $("#telephone").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var address = $("#address").val();
        var avatar = $("#avatar").val();
        var notes = $("#notes").val();
        var tags = [];
        $('.create-tags:checked').each(function (i) {
            tags[i] = $(this).val();
        });

        if (email != "" && telephone != "" && first_name != "" && last_name != "") {
            var contact = new Contact({
                email,
                telephone,
                first_name,
                last_name,
                address,
                avatar,
                tags,
                notes
            });
            contact.save({}, {
                wait: true,
                success: function (res) {
                    $('#flashMessage')
                        .hide()
                        .slideDown(1000)
                        .delay(3000)
                        .slideUp();
                    $("#exampleModalToggle").modal('hide');
                    $('#createContactForm').trigger("reset");
                    $("#createContactForm").removeClass('was-validated');
                    contacts.add(res);
                    console.log("The model has been saved to the server");
                },
                error: function () {
                    $("#create-form-alert").css("display", "block");
                    console.log("Something went wrong while saving the model");
                }
            });
        }
    }
})

// initialize a new createContactView object
var createContactView = new CreateContactView();
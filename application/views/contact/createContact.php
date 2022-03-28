<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalToggleLabel">Create Contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert" id="create-form-alert" style="display:none;">
                    A contact with the same email or telephone number already exists.
                </div>
                <form class="row g-3 needs-validation" id="createContactForm" novalidate>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <input type="email" class="form-control" id="email" aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="text" class="form-control" id="telephone" required>
                        <div class="invalid-feedback">Telephone number is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" required>
                        <div class="invalid-feedback">First name is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" required>
                        <div class="invalid-feedback">Last name is required.</div>
                    </div>

                    <div class="col-md-12">
                        <label for="address" class="form-label" formnovalidate="formnovalidate">Address</label>
                        <input type="text" class="form-control" id="address">
                    </div>

                    <div class="col-md-12">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input type="text" class="form-control" id="avatar">
                    </div>

                    <label for="" class="form-label">Tags</label>
                    <div class="col-md-12">
                        <div class="form-check form-check-inline mr-5">
                            <label class="form-check-label" for="inlineCheckbox2">Family</label>
                            <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox1" value="1">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Friend</label>
                            <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox2" value="2">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Relative</label>
                            <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox3" value="3">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Work-associate</label>
                            <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox4" value="4">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Spouse</label>
                            <input name="selector[]" class="form-check-input create-tags" type="checkbox" id="inlineCheckbox5" value="5">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" rows="4"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="create" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
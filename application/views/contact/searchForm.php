<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModal2ToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModal2ToggleLabel">Advance Search</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="searchContactForm">
                    <div class="col-md-6">
                        <label for="search-email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="search-email" aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="search-telephone" class="form-label">Telephone</label>
                        <input type="text" class="form-control" id="search-telephone">
                    </div>
                    <div class="col-md-6">
                        <label for="search-first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="search-first-name">
                    </div>
                    <div class="col-md-6">
                        <label for="search-last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="search-last-name">
                    </div>

                    <div class="col-md-12">
                        <label for="search-address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="search-address">
                    </div>

                    <label for="startDate" class="form-label">Date Range</label>
                    <div class="col-md-6">
                        <input type="date" class="form-control" id="startDate" />
                    </div>
                    <div class="col-md-6">
                        <input type="date" class="form-control" id="endDate" />
                    </div>

                    <label for="" class="form-label">Tags</label>
                    <div class="col-md-12">
                        <div class="form-check form-check-inline mr-5">
                            <label class="form-check-label" for="inlineCheckbox2">Family</label>
                            <input name="search-selector[]" class="form-check-input search-tags" type="checkbox" id="search-checkbox-1" value="1">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Friend</label>
                            <input name="search-selector[]" class="form-check-input search-tags" type="checkbox" id="search-checkbox-2" value="2">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Relative</label>
                            <input name="search-selector[]" class="form-check-input search-tags" type="checkbox" id="search-checkbox-3" value="3">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Work-associate</label>
                            <input name="search-selector[]" class="form-check-input search-tags" type="checkbox" id="search-checkbox-4" value="4">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox3">Spouse</label>
                            <input name="search-selector[]" class="form-check-input search-tags" type="checkbox" id="search-checkbox-5" value="5">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-12">
                            <button type="submit" data-bs-dismiss="modal" id="search-submit" class="btn btn-success">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
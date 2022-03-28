<?php include "./application/views/includes/header.php" ?>

<body>
    <?php include "./application/views/includes/sidenav.php" ?>
    <div class="home-section">
        <div class="main-container container">
            <div class="search-container">
                <?php include './application/views/contact/createContact.php'; ?>
                <?php include './application/views/contact/searchForm.php'; ?>
                <div class="button-container">
                    <a class="btn btn-outline-dark" data-bs-toggle="modal" href="#exampleModalToggle2" role="button">
                        <i class="fas fa-sort-amount-down-alt"></i>
                        Filter
                    </a>
                    <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Create</a>
                </div>
            </div>
            <div id="flashMessage">
                New contact was added!
            </div>
            <table class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                    <tr>
                        <th style="text-align: center;">Contact</th>
                        <th style="text-align: center;">Email</th>
                        <th style="text-align: center;">Telephone</th>
                        <th style="text-align: center;">Address</th>
                        <th style="text-align: center;">Favorite</th>
                        <th style="text-align: center;">Tags</th>
                    </tr>
                </thead>
                <tbody id="contact-list-container">
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"></script>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"> </script>
    <script src="<?php echo base_url('application/views/models/Contact.js'); ?>"> </script>
    <script>
        // initialize the required collections.
        var contacts = new Contacts();
        var searchContacts = new SearchContacts();
    </script>
    <script src="<?php echo base_url('application/views/backboneviews/searchContactView.js'); ?>"></script>
    <script src="<?php echo base_url('application/views/backboneviews/createContactView.js'); ?>"></script>
    <script src="<?php echo base_url('application/views/backboneviews/contactListView.js'); ?>"></script>
</body>

</html>
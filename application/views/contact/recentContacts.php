<?php include "./application/views/includes/header.php" ?>

<body>
    <?php include "./application/views/includes/sidenav.php" ?>
    <div class="home-section">
        <div class="main-container container">
            <h2 class="mt-5 mb-5">Recent Contacts</h2>
            <table class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                    <tr>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Address</th>
                        <th>Favorite</th>
                        <th>Created_data</th>
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
    <script src="<?php echo base_url('application/views/models/Contact.js'); ?>"></script>

    <script>
        var recentContacts = new RecentContacts();
    </script>
    <script src="<?php echo base_url('application/views/backboneviews/recentContactListView.js'); ?>"></script>
</body>

</html>
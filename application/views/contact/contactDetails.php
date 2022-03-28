<?php include "./application/views/includes/header.php" ?>

<body>
    <?php include "./application/views/includes/sidenav.php" ?>
    <div class="home-section mt-4">
        <p hidden id="contact-id"><?php echo $contact_id ?></p>
        <div class="main-container container">
            <div id="contact-view">

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"></script>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"> </script>
    <script src="<?php echo base_url('application/views/models/Contact.js'); ?>"></script>>

    <script>
        var contact = new Contact();
        var contactId = $("#contact-id").text();
    </script>
    <script src="<?php echo base_url('application/views/backboneviews/contactDetailsView.js'); ?>"></script>
</body>

</html>
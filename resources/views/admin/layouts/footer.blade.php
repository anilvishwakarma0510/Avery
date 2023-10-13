</div>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
  $('.friend-drawer--onhover').on('click', function() {

    $('.chat-bubble').hide('slow').show('slow');

  });
</script>

<script>
  $(document).ready(function() {
    $('.DataTable').DataTable({
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    });
  });
  //# sourceURL=pen.js
</script>
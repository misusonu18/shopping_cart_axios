<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/js/alertify.min.js"></script>
<script src="/js/app.js"></script>

<?php
    if (isset($discountError)) {
        if ($discountError == 1) {
            echo "
                <script type = 'text/javascript'>
                    alertify.notify('Discount Error', 'error', 2,); 
                    });
                </script>
            ";
        }
    }
?>
</body>
</html>
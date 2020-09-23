<!--For Sandbox-->
<script id="context" type="text/javascript"
        src="https://sandbox-payments.open.money/layer"></script>
<script>

    //You can bind the Layer.checkout initialization script to a button click event.
    //Binding inside a click event open Layer payment page on click of a button
    Layer.checkout({
            token: "sb_pt_H9hFQwU4dEHC55",
            accesskey: "cbfba3d0-ba9e-11ea-8e90-4384c267ea22"
        },
        function(response) {
          console.log(response);
            if (response.status == "captured") {

                // response.payment_token_id
                // response.payment_id

            } else if (response.status == "created") {


            } else if (response.status == "pending") {


            } else if (response.status == "failed") {
              console.log('failed')

            } else if (response.status == "cancelled") {

            }
        },
        function(err) {
        console.log(err)
            //integration errors
        }
    );
</script>

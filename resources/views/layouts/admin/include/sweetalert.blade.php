<script>
    const button = document.getElementById('logout_sweetalert');

    button.addEventListener('click', e => {
        e.preventDefault();

        Swal.fire({
            html: `
                <h2>{{__('starter.Are you sure you want to log out')}}</h2>
                <p>{{__('starter.You will be logged out of the system and will need to log in again to access your account')}}</p>
            `,
            icon: "question",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "{{__('starter.Yes log out')}}",
            cancelButtonText: "{{__('starter.Cancel')}}",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: 'btn btn-danger'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout_form').submit();
            }
        });
    });
</script>

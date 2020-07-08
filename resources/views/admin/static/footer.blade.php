<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2020
        <div class="bullet"></div>
        PCHELKA
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('modules/jquery.min.js')}}"></script>
<script src="{{asset('modules/popper.js')}}"></script>
<script src="{{asset('modules/tooltip.js')}}"></script>
<script src="{{asset('modules/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('modules/moment.min.js')}}"></script>
<script src="{{asset('js/stisla.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>

<!-- InputMask -->
<script src="https://adminlte.io/themes/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script>

    $(function () {
//Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()
    })
</script>
<!-- date-range-picker -->
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.edit1Btn').on('click', function () {
            $('#editcanceled').modal('show');

        });
        $('#edit1Form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: "/schedule/deleteSchedule",
                success: function (response) {
                    console.log(response);
                    $('#editcanceled').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.log(error)
                    // alert("Data Not Saved");
                }
            });
        });
    });
</script>

</body>
</html>

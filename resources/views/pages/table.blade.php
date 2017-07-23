@extends('app')


@section('content')
    <br>

    @if ($row_n != 0 AND $col_n !=0)

        <table>

        @for ($i = 0; $i <= $row_n; $i++)

            <tr @if($i === 0) style="border-bottom: 1px solid black;" @endif >

            @for ($j = 0; $j <= $col_n; $j++)

                <td @if($j === 0) style="border-right: 1px solid black;" @endif >
                    <input type="checkbox" value="{{ $i . "x" . $j }}">
                </td>

            @endfor

            </tr>

        @endfor

        </table>

    @endif


@stop


@section('scripts')
    <script>

        jQuery(document).ready(function($) {
            @foreach ($checked_boxes as $checked_box)
                var row = {{ $checked_box->checkbox_row }};
                var col = {{ $checked_box->checkbox_col }};

                if ( $("input[type='checkbox'][value='" + row + "x" + col + "']").length) {
                    $("input[type='checkbox'][value='" + row + "x" + col + "']").prop("checked", true);

                    if ($("input[type='checkbox'][value$='" + "x" + col + "']").not("[value^='" + 0 + "x']").not(':checked').length == 0)
                        $("input[type='checkbox'][value='" + 0 + "x" + col + "']").prop("checked", true).change();

                    if ($("input[type='checkbox'][value^='" + row + "x" + "']").not("[value$='" + "x" + 0 + "']").not(':checked').length == 0)
                        $("input[type='checkbox'][value='" + row + "x" + 0 + "']").prop("checked", true).change();
                }
            @endforeach

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("input[type='checkbox']").change(function() {
            var cord = this.value.split("x");
            var row = cord[0];
            var col = cord[1];
            if(row == 0 && col == 0) { //0x0 cell changed

                if(this.checked)
                    $("input[type='checkbox'][value!='0x0']").not(':checked').prop("checked", true).change();  //Check all unchecked cells
                else
                    $("input:checkbox:checked[value!='0x0']").prop("checked", false).change();  //Uncheck all checked cells
            }
            else if(row == 0) { // 0xN cell changed
                if(this.checked) {
                    $("input[type='checkbox'][value$='x" + col + "']").not("[value^='" + row + "x']").not(':checked').prop("checked", true).change(); //Check all unchecked cells in column
                    if ($("input[type='checkbox'][value^='0x']").not("[value='0x0']").not(':checked').length == 0)
                        $("input[type='checkbox'][value='0x0']").prop("checked", true);
                }
                else {
                    $("input:checkbox:checked[value$='x" + col + "']").not("[value^='" + row + "x']").prop("checked", false).change(); //Uncheck all cells in column
                    $("input[type='checkbox'][value='0x0']").prop("checked", false);
                }
            }
            else if(col == 0) { // Nx0 cell changed

                if(this.checked) {
                    $("input[type='checkbox'][value^='" + row + "x']").not("[value$='x" + col + "']").not(':checked').prop("checked", true).change(); //Check all unchecked cells in row
                    if ($("input[type='checkbox'][value$='x0']").not("[value='0x0']").not(':checked').length == 0)
                        $("input[type='checkbox'][value='0x0']").prop("checked", true);
                }
                else {
                    $("input:checkbox:checked[value^='" + row + "x']").not("[value$='x" + col + "']").prop("checked", false).change(); //Uncheck all cells in row
                    $("input[type='checkbox'][value='0x0']").prop("checked", false);
                }

            }
            else { // else


                if(this.checked) {
                    if ($("input[type='checkbox'][value$='x" + col + "']").not("[value^='" + 0 + "x']").not(':checked').length == 0)
                        $("input[type='checkbox'][value='0x" + col + "']").prop("checked", true).change();

                    if ($("input[type='checkbox'][value^='" + row + "x']").not("[value$='x" + 0 + "']").not(':checked').length == 0)
                        $("input[type='checkbox'][value='" + row + "x0']").prop("checked", true).change();

                    //add cell to DB
                    $.ajax({
                        type: "POST",
                        url: '/create',
                        data: {
                            'checkbox_row': row,
                            'checkbox_col':col
                        },
                        success: function( msg ) {
                            console.log(msg);
                        }
                    });
                }
                else { //unchecked
                    $("input[type='checkbox'][value='" + row + "x0']").prop("checked", false);
                    $("input[type='checkbox'][value='0x" + col + "']").prop("checked", false);
                    $("input[type='checkbox'][value='0x0']").prop("checked", false);

                    //delete cell from DB
                    $.ajax({
                        type: "POST",
                        url: '/delete',
                        data: {
                            'checkbox_row': row,
                            'checkbox_col':col
                        },
                        success: function( msg ) {
                            console.log(msg);
                        }
                    });
                }
            }
        });
    </script>
@stop
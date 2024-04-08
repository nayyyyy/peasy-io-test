@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <table id="profileTable" class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Date</th>
                    <th width="20%">Male Count</th>
                    <th width="20%">Male Average Age</th>
                    <th width="20%">Female Count</th>
                    <th width="20%">Female Average Age</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var urlDeleteProfile = "{{route('admin.profiles.destroy', ":id")}}"
        var csrfToken = $('meta[name="csrf-token"]').attr('content')

        var datatable = $("#profileTable")
            .DataTable({
                serverSide: true,
                processing: true,
                searching: false,
                responsive: true,
                ajax: {
                    url: "{{route('api.daily-records.datatable')}}",
                    type: "GET",
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: "created_at",
                        name: "created_at",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "male_count",
                        name: "male_count",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "male_avg_age",
                        name: "male_avg_age",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function(data){
                            return parseFloat(data).toFixed(2)
                        }
                    },
                    {
                        data: "female_count",
                        name: "female_count",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "female_avg_age",
                        name: "female_avg_age",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function(data){
                            return parseFloat(data).toFixed(2)
                        }
                    }
                ],
                drawCallback: function (settings) {
                    let api = this.api();
                    let startIndex = api.context[0]._iDisplayStart;
                    api.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, index) {
                        cell.innerHTML = startIndex + index + 1;
                    });
                }
            })
    </script>
@endsection

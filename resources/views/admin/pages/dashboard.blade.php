@extends('admin.layouts.layout')

@section('content')
    <div class="row-cols-3 row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Male Count
                </div>
                <div class="card-body">
                    {{$maleCount}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Female Count
                </div>
                <div class="card-body">
                    {{$femaleCount}}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Total Profile
                </div>
                <div class="card-body">
                    {{$total}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-10 mb-3">
            <input class="form-control" id="name" autocomplete="off" type="text">
        </div>
        <div class="col-md-12 col-lg-2 mb-3">
            <button type="button" id="search" class="w-full btn btn-primary">Search by Name</button>
        </div>
        <div class="col-12">
            <table id="profileTable" class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="25%">Name</th>
                    <th width="20%">Age</th>
                    <th width="20%">Gender</th>
                    <th width="30%">Created At</th>
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
                    url: "{{route('api.profiles.datatable')}}",
                    type: "GET",
                    data: function (data){
                        data.name = $('#name').val()
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: "full_name",
                        name: "full_name",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "age",
                        name: "age",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "gender",
                        name: "gender",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            return data ? "Male" : "Female";
                        }
                    },
                    {
                        data: "created_at",
                        name: "created_at",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return "<div class='d-flex mt-auto justify-content-center align-items-center'>" +
                                `<form id='deleteForm' action='${urlDeleteProfile.replace(':id', row.id)}' method='post'>` +
                                `<input type='text' hidden name='_token' value="${csrfToken}">` +
                                `<input type='text' hidden name='_method' value="DELETE">` +
                                `<button class='btn btn-danger btn-sm' type='submit'>Delete</button>` +
                                `</form>` +
                                "</div>"
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

        $(document).ready(() => {
            $('#search').click(() => {
                datatable.draw("first").reload()
            })
        })
    </script>
@endsection

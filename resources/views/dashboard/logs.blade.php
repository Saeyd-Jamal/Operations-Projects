<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الأحداث</h2>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نوع الحدث</th>
                                        <th>الحدث</th>
                                        <th>المستخدم</th>
                                        <th>تاريخ الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{$log->type}}</td>
                                        <td>{{$log->message}}</td>
                                        <td>{{$log->user_name}}</td>
                                        <td>{{$log->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{$logs->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>

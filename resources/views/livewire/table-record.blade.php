<div class="card shadow">
    @push('styles')
        <link rel="stylesheet" href="{{asset('css/stickyTable.css')}}">
    @endpush
    <div class="card-header">
        <div class="row align-items-center justify-content-between">
            <h2 class="card-title">بيانات المرضى</h2>
            <div class="form-group col-md-3">
                <x-form.input type="search" name="name" placeholder="إملأ اسم المريض" wire:input="search($event.target.value)" wire:model="filterData.name" />
            </div>
            <div>
                <button class="btn btn-warning" id="filter-btn" title="التصفية">
                    <i class="fe fe-filter"></i>
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddPatient">
                    اضافة مريض جديد
                </button>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#printReport">
                    طباعة تقرير
                </button>
            </div>
        </div>
        <form action="#">
            <div class="row" id="filter-div" style="display: none;">
                <div class="form-group col-md-3">
                    <x-form.input name="patient_id" placeholder="أدخل رقم الهوية" label="رقم الهوية" maxlength="9" wire:model="filterData.patient_id" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="number" name="financier_number" list="financier_numbers_list" label="رقم الممول" wire:model="filterData.financier_number" />
                    <datalist id="financier_numbers_list">
                        @foreach ($financier_numbers as $financier)
                            <option value="{{$financier}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="operation" list="operations_list" label="العملية" wire:model="filterData.operation" />
                    <datalist id="operations_list">
                        @foreach ($operations as $operation)
                            <option value="{{$operation}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="doctor" list="doctors_list" label="اسم الطبيب" wire:model="filterData.doctor" />
                    <datalist id="doctors_list">
                        @foreach ($doctors as $doctor)
                            <option value="{{$doctor}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="anesthesia" list="anesthesias_list" label="طبيب التخدير" wire:model="filterData.anesthesia" />
                    <datalist id="anesthesias_list">
                        @foreach ($anesthesias as $anesthesia)
                            <option value="{{$anesthesia}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="from_date" label="من تاريخ" wire:model="filterData.from_date" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="to_date" label="إلى تاريخ" wire:model="filterData.to_date" />
                </div>
                <div class="form-group col-md-3">
                    <label for="done">عمليات منجزة</label>
                    <select name="done" id="done" class="form-control" wire:model="filterData.done">
                        <option value="" selected>كل العمليات</option>
                        <option value="1">منجزة</option>
                        <option value="0">غير منجزة</option>
                    </select>
                </div>
                <div class="form-group col-md-12 d-flex justify-content-end">
                    <button type="reset" class="btn btn-danger m-2" wire:click="resetForm">مسح</button>
                    <button type="button" class="btn btn-primary m-2" wire:click="filter">تطبيق</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body table-container">
        <table class="table table-bordered table-hover mb-0"  id="sticky">
            <thead>
                <tr>
                    @can('update','App\\Models\Record')
                        <th></th>
                    @endcan
                    <th>#</th>
                    <th>تم</th>
                    <th>التاريخ</th>
                    <th class="sticky">الاسم</th>
                    <th>رقم الممول</th>
                    <th>العمر</th>
                    <th>الهوية</th>
                    <th>جوال 1</th>
                    <th>جوال 2</th>
                    <th>العملية</th>
                    <th>الطبيب</th>
                    <th>التكلفة</th>
                    @can('financial','App\\Models\Record')
                    <th>حصة الطبيب</th>
                    <th>طبيب التخدير</th>
                    <th>حصة التخدير</th>
                    <th>المبيت</th>
                    <th>خاص</th>
                    @endcan
                    <th>ملاحظات</th>
                    <th>المستخدم</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <style>
                    th{
                        padding: 3px 10px !important;
                        color: #000 !important;
                    }
                    td{
                        white-space: nowrap;
                        padding: 3px 10px !important;
                        color: #000 !important;
                    }
                    table td.description {
                        white-space: nowrap; /* منع التفاف النص */
                        overflow: hidden; /* إخفاء النص الذي يتجاوز حدود الخلية */
                        text-overflow: ellipsis; /* إظهار النقاط المتقطعة عند تجاوز الحد */
                        max-width: 200px; /* تحديد الحد الأقصى لعرض الخلية */
                        padding: 10px;
                        transition: all 0.5s ease; /* تأثير سلس عند تغيير العرض */
                    }
                    table td.description:hover {
                        max-width: 500px; /* تكبير الخلية عند الاقتراب */
                        white-space: normal; /* السماح للنص بالالتفاف */
                    }
                </style>
                @foreach ($records as $index =>$record)
                    <tr>
                        @can('update','App\\Models\Record')
                        <td>
                            <button type="button" class="btn btn-info btn-sm" wire:click="openModal({{$record->id}})">
                                <i class="fe fe-edit-3 text-white"></i>
                            </button>
                        </td>
                        @endcan
                        <td>{{$index+1}}</td>
                        <td>
                            <input type="checkbox" name="done" id="" disabled @if ($record->done == 1) checked @endif>
                        </td>
                        <td>{{$record->date}}</td>
                        <td class="sticky">{{$record->name}}</td>
                        <td>{{$record->financier_number}}</td>
                        <td>{{$record->age}}</td>
                        <td>{{$record->patient_ID}}</td>
                        <td>{{$record->phone_number1}}</td>
                        <td>{{$record->phone_number2}}</td>
                        <td>{{$record->operation}}</td>
                        <td>{{$record->doctor}}</td>
                        <td>{{$record->amount}}</td>
                        @can('financial','App\\Models\Record')
                        <td>{{$record->doctor_share}}</td>
                        <td>{{$record->anesthesia}}</td>
                        <td>{{$record->anesthesiologists_share}}</td>
                        <td>{{$record->bed}}</td>
                        <td>{{$record->private}}</td>
                        @endcan
                        <td class="description">{{$record->notes}}</td>
                        <td>{{$record->user}}</td>
                        <td>
                            @can('delete','App\\Models\Record')
                            <form action="{{route('records.destroy', $record->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fe fe-trash text-white"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @if ($showModal)
                <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);overflow-y: auto;" data-dismiss="modal" wire:click="closeModal">
                    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document" wire:click.stop> <!-- wire:click.stop يمنع إغلاق المودال عند الضغط داخله -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">المريض : {{$dataModal['name']}}</h5>
                                <button type="button" wire:click="closeModal" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <x-form.input name="name" label="اسم المريض" wire:model="dataModal.name" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        @can('date','App\\Models\Record')
                                            <x-form.input type="date" name="date" label="التاريخ" wire:model="dataModal.date" />
                                        @else
                                            <x-form.input type="date" name="date" label="التاريخ" wire:model="dataModal.date" disabled />
                                        @endcan
                                    </div>
                                    <div class="form-group col-md-4">
                                        <x-form.input name="patient_ID" maxlength="9" label="رقم الهوية" wire:model="dataModal.patient_ID" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <x-form.input type="number" name="age" min="0" label="عمر المريض" wire:model="dataModal.age" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <x-form.input name="phone_number1" maxlength="10" label="جوال 1" wire:model="dataModal.phone_number1" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <x-form.input name="phone_number2" maxlength="10" label="جوال 2" wire:model="dataModal.phone_number2" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <x-form.input type="number" name="financier_number" list="financier_numbers_list" label="رقم الممول" wire:model="dataModal.financier_number"/>
                                        <datalist id="financier_numbers_list">
                                            @foreach ($financier_numbers as $financier)
                                                <option value="{{$financier}}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <x-form.input name="operation" list="operations_list" label="العملية" wire:model="dataModal.operation" />
                                        <datalist id="operations_list">
                                            @foreach ($operations as $operation)
                                                <option value="{{$operation}}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <x-form.input name="doctor" list="doctors_list" label="اسم الطبيب" wire:model="dataModal.doctor" />
                                        <datalist id="doctors_list">
                                            @foreach ($doctors as $doctor)
                                                <option value="{{$doctor}}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <x-form.input name="anesthesia" list="anesthesias_list" label="طبيب التخدير" wire:model="dataModal.anesthesia" />
                                        <datalist id="anesthesias_list">
                                            @foreach ($anesthesias as $anesthesia)
                                                <option value="{{$anesthesia}}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <x-form.input type="number" min="0" name="amount" label="م مطلوب" :value="$dataModal['amount']" wire:input="amountS($event.target.value)" />
                                    </div>
                                    @can('financial','App\\Models\Record')
                                    <div class="form-group col-md-3">
                                        <x-form.input type="number" min="0" name="doctor_share" label="حصة الطبيب" wire:model="dataModal.doctor_share" />
                                    </div>
                                    <div class="form-group col-md-3">
                                        <x-form.input type="number" min="0" name="anesthesiologists_share" label="حصة طبيب التخدير" wire:model="dataModal.anesthesiologists_share" />
                                    </div>

                                    <div class="form-group col-md-3">
                                        <x-form.input type="number" min="0" name="bed" label="المبيت" wire:model="dataModal.bed" />
                                    </div>
                                    <div class="form-group col-md-3">
                                        <x-form.input type="number" min="0" name="private" label="خاص" wire:model="dataModal.private" />
                                    </div>
                                    @endcan
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <x-form.input type="text" name="notes" label="ملاحظات" wire:model="dataModal.notes" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <div class="form-group col-md-3">
                                    <input type="checkbox" name="done" id="done" @if($dataModal['done'] == 1) checked @endif wire:model="dataModal.done">
                                    <label for="done">تمت العملية</label>
                                </div>
                                <button type="button" wire:click="save" class="btn btn-primary" >حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade @if($show) show @endif" id="AddPatient" tabindex="-1" role="dialog" aria-labelledby="AddPatientTitle" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddPatientTitle">إضافة مريض لمشروع العمليات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('records.store')}}" method="post">
            @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <x-form.input name="name" label="اسم المريض" required />
                        </div>
                        <div class="form-group col-md-4">
                            @can('date','App\\Models\Record')
                                <x-form.input type="date" name="date" label="التاريخ" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"  required />
                            @else
                                <x-form.input type="date" name="date" label="التاريخ" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly />
                            @endcan
                        </div>
                        <div class="form-group col-md-4">
                            <x-form.input name="patient_ID" maxlength="9" label="رقم الهوية" required />
                        </div>
                        <div class="form-group col-md-4">
                            <x-form.input type="number" name="age" min="0" label="عمر المريض" required />
                        </div>
                        <div class="form-group col-md-4">
                            <x-form.input name="phone_number1" maxlength="10" label="جوال 1" required />
                        </div>
                        <div class="form-group col-md-4">
                            <x-form.input name="phone_number2" maxlength="10" label="جوال 2"  />
                        </div>
                        <div class="form-group col-md-4">
                            <x-form.input type="number" name="financier_number" list="financier_numbers_list" label="رقم الممول" />
                            <datalist id="financier_numbers_list">
                                @foreach ($financier_numbers as $financier)
                                    <option value="{{$financier}}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input name="operation" list="operations_list" label="العملية" required />
                            <datalist id="operations_list">
                                @foreach ($operations as $operation)
                                    <option value="{{$operation}}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input name="doctor" list="doctors_list" label="اسم الطبيب" />
                            <datalist id="doctors_list">
                                @foreach ($doctors as $doctor)
                                    <option value="{{$doctor}}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input name="anesthesia" list="anesthesias_list" label="طبيب التخدير" />
                            <datalist id="anesthesias_list">
                                @foreach ($anesthesias as $anesthesia)
                                    <option value="{{$anesthesia}}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <x-form.input type="number" min="0" name="amount" label="م مطلوب"  required />
                        </div>
                        @can('financial','App\\Models\Record')
                        <div class="form-group col-md-3">
                            <x-form.input type="number" min="0" name="doctor_share" label="حصة الطبيب" />
                        </div>
                        <div class="form-group col-md-3">
                            <x-form.input type="number" min="0" name="anesthesiologists_share" label="حصة طبيب التخدير" value="0" />
                        </div>
                        <div class="form-group col-md-3">
                            <x-form.input type="number" min="0" name="bed" label="المبيت" value="0" />
                        </div>
                        <div class="form-group col-md-3">
                            <x-form.input type="number" min="0" name="private" label="خاص" />
                        </div>
                        @endcan
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <x-form.input type="text" name="notes" label="ملاحظات"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="form-group col-md-3">
                        <input type="checkbox" name="done" id="done" >
                        <label for="done">تمت العملية</label>
                    </div>
                    <button type="submit" class="btn btn-primary">أضف</button>
                </div>
            </form>
            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $('#amount').on('input', function() {
                            var amount = $(this).val();
                            if(amount != "" || amount != null){
                                $('#doctor_share').val(amount * 0.4);
                                $('#private').val(amount * 0.05);
                            }
                        })
                    })
                </script>
            @endpush
        </div>
        </div>
    </div>
    <div class="modal fade" id="printReport" tabindex="-1" role="dialog" aria-labelledby="printReportTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printReportTitle">طباعة تقرير</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('records.print')}}" method="post" target="_blank">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="data" value="{{ json_encode($records) }}">
                        <div class="form-group col-md-12">
                            <label for="report">نوع التقرير</label>
                            <select name="report" id="report" class="form-control" required>
                                <option value="" disabled selected>اختر</option>
                                <option value="basic">أساسي</option>
                                @can('financial','App\\Models\Record')
                                <option value="mali">مالي</option>
                                @endcan
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">طباعة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $("#filter-btn").click(function () {
                    $("div#filter-div").slideToggle();
                });
            })
        </script>
    @endpush
</div>

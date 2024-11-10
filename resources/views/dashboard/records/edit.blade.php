<x-front-layout>
    @push('styles')
        <style>
            .main-content{
                margin: 0 !important;
            }
        </style>
    @endpush
    <div class="row">
        <div class="col-md-12 my-2">
            <div class="card shadow px-2">
                @push('styles')
                    <link rel="stylesheet" href="{{asset('css/stickyTable.css')}}">
                @endpush
                <div class="card-header">
                    <div class="row align-items-center justify-content-between">
                        <h2 class="card-title">بيانات المرضى</h2>
                    </div>
                </div>
                <div class="card-body table-container">
                    <form action="{{route('records.update',$record->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="form-group col-md-12">
                                <x-form.input name="name" label="اسم المريض" required :value="$record->name" />
                            </div>
                            <div class="form-group col-md-3">
                                @can('date','App\\Models\Record')
                                    <x-form.input type="date" name="date" label="التاريخ" :value="$record->date"  required />
                                @else
                                    <x-form.input type="date" name="date" label="التاريخ" :value="$record->date" readonly />
                                @endcan
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input name="patient_ID" maxlength="9" label="رقم الهوية" required :value="$record->patient_ID" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input type="number" name="age" min="0" label="عمر المريض" required :value="$record->age" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input name="phone_number1" maxlength="10" label="جوال 1" required :value="$record->phone_number1" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input name="phone_number2" maxlength="10" label="جوال 2"  :value="$record->phone_number2" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input type="number" name="financier_number" list="financier_numbers_list" label="رقم الممول" :value="$record->financier_number" />
                                <datalist id="financier_numbers_list">
                                    @foreach ($financier_numbers as $financier)
                                        <option value="{{$financier}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form.input name="operation" list="operations_list" label="العملية" required :value="$record->operation" />
                                <datalist id="operations_list">
                                    @foreach ($operations as $operation)
                                        <option value="{{$operation}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form.input name="doctor" list="doctors_list" label="اسم الطبيب" required :value="$record->doctor" />
                                <datalist id="doctors_list">
                                    @foreach ($doctors as $doctor)
                                        <option value="{{$doctor}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form.input name="anesthesia" list="anesthesias_list" label="طبيب التخدير" :value="$record->anesthesia" />
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
                                <x-form.input type="number" min="0" name="amount" label="م مطلوب"  required :value="$record->amount" />
                            </div>
                            @can('financial','App\\Models\Record')
                            <div class="form-group col-md-3">
                                <x-form.input type="number" min="0" name="doctor_share" label="حصة الطبيب" :value="$record->doctor_share" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input type="number" min="0" name="anesthesiologists_share" label="حصة طبيب التخدير" value="0" :value="$record->anesthesiologists_share" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input type="number" min="0" name="bed" label="المبيت" value="0" :value="$record->bed" />
                            </div>
                            <div class="form-group col-md-3">
                                <x-form.input type="number" min="0" name="private" label="خاص" :value="$record->private" />
                            </div>
                            @endcan
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <x-form.input type="text" name="notes" label="ملاحظات" :value="$record->notes" />
                            </div>
                            <div class="form-group col-md-6">
                                <x-form.input type="text" name="notes_2" label="ملاحظات ثانوية" :value="$record->notes_2" />
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-between">
                            <div class="form-group col-md-3">
                                <input type="checkbox" name="done" id="done" @checked($record->done) >
                                <label for="done">تمت العملية</label>
                            </div>
                            <button type="submit" class="btn btn-primary">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#amount').on('input', function() {
                    var amount = $(this).val();
                    if(amount != "" || amount != null){
                        $('#doctor_share').val((amount * 0.4).toFixed(2));
                        $('#private').val((amount * 0.05).toFixed(2));
                    }
                })
            })
        </script>
    @endpush
</x-front-layout>

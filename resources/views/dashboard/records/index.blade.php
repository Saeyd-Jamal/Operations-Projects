<x-front-layout>
    @push('styles')
    <style>
        .main-content{
            margin: 0 !important;
        }
        .container-fluid{
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/handsontable.full.min.css')}}">
    <style>
        #example {
            overflow: hidden; /* إضافة التمرير إذا لزم الأمر */
            height: calc(100vh - 70px); /* تحديد ارتفاع الجدول */
            width: 100%; /* العرض الكامل */
        }
        .htDatepickerHolder{
            top: auto !important;
            bottom: 27px !important;
        }
        .duplicate-cell {
            background-color: #000 !important; /* اللون الأسود للخلفية */
            color: white !important; /* اللون الأبيض للنص */
        }
        td{
            padding: 4px 4px !important;
            font-size: 18px !important;
        }
        /* تنسيق الصفوف الزوجية */
        .handsontable tr:nth-child(even) td {
            background-color: #f0f0f0; /* اللون الرمادي */
        }


    </style>
    @endpush
    @push('extentions')
    @can('create','App\\Models\Record')
    <li class="nav-item">
        <button class="nav-link text-dark my-2" style="background: none;border:0;" id="addRowButton">
            <i class="fe fe-plus fe-16"></i>
        </button>
    </li>
    @endcan
    @can('update','App\\Models\Record')
    <li class="nav-item">
        <button class="nav-link text-dark my-2" style="background: none;border:0;" id="saveAllButton">
            <i class="fe fe-save fe-16"></i>
        </button>
    </li>
    @endcan
    @can('export','App\\Models\Record')
    <li class="nav-item">
        <button class="nav-link text-dark my-2" style="background: none;border:0;" data-toggle="modal" data-target="#printReport" >
            <i class="fe fe-download fe-16"></i>
        </button>
    </li>
    @endcan
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="example" class="hot"></div>                <!-- إضافة داتا ليست هنا -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="printReport" tabindex="-1" role="dialog" aria-labelledby="printReportTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printReportTitle">طباعة تقرير</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="printReportForm" action="{{route('records.print')}}" method="post" target="_blank">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="data" id="dataInput" value="">
                        <div class="form-group col-md-12">
                            <label for="report">نوع التقرير</label>
                            <select name="report" id="report" class="form-control" required="">
                                <option value="" disabled="" selected="">اختر</option>
                                <option value="basic">أساسي</option>
                                @can('fanancial','App\\Models\Record')
                                <option value="mali">مالي</option>
                                @endcan
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="printReportButton">طباعة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('js/handsontable.full.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var financier_numbers = @json($financier_numbers);
            var operations = @json($operations);
            var doctors = @json($doctors);
            var anesthesias = @json($anesthesias);

            var container = document.getElementById('example');
            var hot = new Handsontable(container, {
                colHeaders: [
                    "تم",
                    "التاريخ",
                    "الاسم",
                    "رقم الممول",
                    "العمر",
                    "الهوية",
                    "جوال 1",
                    "جوال 2",
                    "العملية",
                    "الطبيب",
                    "طبيب التخدير",
                    "م المطلوب",
                    @can('fanancial','App\\Models\Record')
                    "حصة الطبيب",
                    "التخدير",
                    "المبيت",
                    "خاص",
                    @endcan
                    "ملاحظات"
                ],
                columns: [
                    { data: "done", type: "checkbox", checkedTemplate: 1, uncheckedTemplate: 0 },
                    {
                        data: "date",
                        type: "date",
                        dateFormat: "YYYY-MM-DD",
                        correctFormat: true,
                        @cannot('update', \App\Models\Record::class)
                            readOnly: true,
                        @endcannot
                    },
                    { data: "name", type: "text" },
                    {
                        data: 'financier_number',
                        type: 'autocomplete',
                        source: financier_numbers,  // الخيارات المتاحة في القائمة المنسدلة
                        strict: false,  // السماح بإدخال قيم خارج القائمة
                        filter: true  // لتصفية الخيارات بناءً على المدخلات
                    },
                    { data: "age", type: "text" },
                    { data: "patient_ID", type: "text" },
                    { data: "phone_number1", type: "text" },
                    { data: "phone_number2", type: "text" },
                    {
                        data: 'operation',
                        type: 'autocomplete',
                        source: operations,  // الخيارات المتاحة في القائمة المنسدلة
                        strict: false,  // السماح بإدخال قيم خارج القائمة
                        filter: true  // لتصفية الخيارات بناءً على المدخلات
                    },
                    {
                        data: 'doctor',
                        type: 'autocomplete',
                        source: doctors,  // الخيارات المتاحة في القائمة المنسدلة
                        strict: false,  // السماح بإدخال قيم خارج القائمة
                        filter: true  // لتصفية الخيارات بناءً على المدخلات
                    },
                    {
                        data: 'anesthesia',
                        type: 'autocomplete',
                        source: anesthesias,  // الخيارات المتاحة في القائمة المنسدلة
                        strict: false,  // السماح بإدخال قيم خارج القائمة
                        filter: true  // لتصفية الخيارات بناءً على المدخلات
                    },
                    { data: "amount", type: "numeric" },
                    @can('fanancial','App\\Models\Record')
                    { data: "doctor_share", type: "numeric" },
                    { data: "anesthesiologists_share", type: "numeric" },
                    { data: "bed", type: "numeric" },
                    { data: "private", type: "numeric" },
                    @endcan
                    { data: "notes", type: "text", width: 150 }
                ],
                rowHeaders: true,
                filters: true, // تفعيل الفلترة
                dropdownMenu: ['alignment','filter_by_condition', 'filter_by_value', 'filter_action_bar'],
                manualRowResize: true,
                manualColumnResize: true,
                renderAllRows: false,
                viewportHeight: 400,
                licenseKey: 'non-commercial-and-evaluation',
                hiddenColumns: {
                    indicators: false,
                },
                contextMenu: true,
                multiColumnSorting: true,
                manualRowMove: true,
                autoWrapCol: true,
                // تثبيت العمودين الأولين
                fixedColumnsStart: 3,
                undo: false,
                @cannot('update', \App\Models\Record::class)
                    readOnly: true // تعيين جميع الخلايا كقراءة فقط
                @endcannot
            });

            // جلب البيانات من API
            function loadData() {
                $.ajax({
                    url: '/records/getData', // API من Laravel
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        hot.loadData(data); // تحميل البيانات إلى الجدول
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            loadData(); // استدعاء الدالة لجلب البيانات

            var update = false;


            let newRows = [];
            let updateRows = [];
            let idsToDelete = [];

            let canCreate = @json(auth()->user()->can('records.create')); // تأكد من استخدام صلاحية المستخدم المناسبة
            let canDelete = @json(auth()->user()->can('records.delete')); // تأكد من استخدام صلاحية المستخدم المناسبة


            hot.addHook('beforeRemoveRow', function(start, end) {
                // التأكد من صلاحية المستخدم للحذف
                if (!canDelete) {
                    alert('لا تملك صلاحية حذف السطر.');
                    return false; // إلغاء الحذف
                }
                // قراءة الصفوف من سطر البداية إلى السطر النهائي
                for (var i = 1; i <= end; i++) {
                    var rowIndex = start;
                    var rowData = hot.getSourceDataAtRow(rowIndex); // الحصول على بيانات الصف
                    idsToDelete.push(rowData.id); // إضافة المعرف إلى المصفوفة
                    rowIndex++;
                }
                update = true;
            });

            // حفظ البيانات المحدثة عند تحرير خلية
            hot.addHook('afterChange', function(changes, source) {
                // تأكد من أن المصدر ليس من حذف الصفوف
                if (source === 'edit' || source === 'Autofill.fill') {
                    changes.forEach(function([row, prop, oldValue, newValue]) {
                        if (prop === 'amount') {
                            let amount = parseFloat(newValue);
                            // التحقق من أن القيمة المدخلة صالحة
                            if (!isNaN(amount)) {
                                // حساب 40% ووضعها في عمود 40%
                                hot.setDataAtCell(row, 11, (amount * 0.40).toFixed(2));
                                // حساب 5% ووضعها في عمود 5%
                                hot.setDataAtCell(row, 15, (amount * 0.05).toFixed(2));
                            }
                        }

                        // إعداد البيانات التي سيتم إرسالها
                        let rowData = hot.getSourceDataAtRow(row);

                        // كود Ajax لإرسال البيانات
                        $.ajax({
                            url: '/records/update-row',  // المسار المناسب في Laravel
                            type: 'POST',
                            data: {
                                rowData: rowData,  // إرسال بيانات الصف المحدث
                                _token: '{{ csrf_token() }}'  // حماية CSRF
                            },
                            success: function(response) {
                                // console.log('تم حفظ التعديلات بنجاح');
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating row:', error);
                            }
                        });
                    });
                    update = true;  // تحديث الحالة
                }

            });

            // مثال لإضافة صف جديد
            function addRow() {
                // استرجاع البيانات الحالية من Handsontable
                let currentData = hot.getSourceData();

                // إنشاء صف جديد ككائن
                let newRow = {
                    done: 0,
                    date: new Date().toISOString().split('T')[0],
                    name: '',
                    financier_number: '',
                    age: '',
                    patient_ID: '',
                    phone_number1: '',
                    phone_number2: '',
                    operation: '',
                    doctor: '',
                    amount: '',
                    doctor_share: '',
                    anesthesia: '',
                    anesthesiologists_share: '',
                    bed: '',
                    private: '',
                    notes: ''
                };

                // إضافة الصف الجديد إلى البيانات
                currentData.push(newRow);

                // تحديث الجدول
                hot.loadData(currentData); // إعادة تحميل البيانات لتحديث الجدول

                // الحصول على رقم السطر الجديد
                let newRowIndex = currentData.length - 1;
                newRows.push(newRowIndex);
                update = true;
            }

            // إضافة حدث عند الضغط على زر الإضافة
            $('#addRowButton').on('click', function() {
                if (!canCreate) {
                    alert('لا تملك صلاحية حذف السطر.');
                    return false; // إلغاء الحذف
                }
                addRow(); // استدعاء الدالة لإضافة صف جديد
            });

            // وظيفة لحفظ جميع البيانات دفعة واحدة
            function saveAllData() {
                $('#spinner').addClass('show');

                // حفظ البيانات الجديدة
                let newData = [];
                for (let i = 0; i < newRows.length; i++) {
                    let rowIndex = newRows[i];
                    let row = hot.getSourceDataAtRow(rowIndex);
                    newData.push(row);
                }

                // الحصول على الأسطر المحذوفة
                let deletedData = idsToDelete;
                // إجراء الحفظ عبر AJAX
                $.ajax({
                    url: '/records/saveData',
                    type: 'POST',
                    data: {
                        newRecords: newData,
                        deletedRecords: deletedData,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        idsToDelete = [];
                        newRows = [];
                        newData = [];
                        loadData();
                        update = false;
                        $('#spinner').removeClass('show');
                    },
                    error: function(xhr, status, error) {
                        $('#spinner').removeClass('show');
                        alert('حدث خطأ في الاتصال: ' + error);
                        update = true;
                    }
                });
                update = false;
            }

            // إضافة زر لحفظ جميع البيانات
            $('#saveAllButton').on('click', function() {
                saveAllData();
            });

            // إضافة حدث لإلغاء تفعيل Ctrl + Z
            hot.addHook('beforeKeyDown', function(event) {
                // if (event.ctrlKey && (event.key === 'z' || event.key === 'ئ')) {
                //     event.preventDefault(); // إلغاء التراجع

                //     alert('وظيفة التراجع تم تعطيلها.'); // رسالة للمستخدم
                // }
                if (event.key === 'Delete') {
                    event.preventDefault(); // إلغاء التراجع
                    hot.undo();
                }
            });

            // رسالة تأكيد عند محاولة مغادرة الصفحة في حال وجود تغييرات غير محفوظة
            window.addEventListener('beforeunload', function(event) {
                console.log("Status of update before unload:", update);
                if (update) {
                    const confirmationMessage = 'هناك تغييرات لم يتم حفظها. هل أنت متأكد أنك تريد مغادرة الصفحة؟';
                    event.preventDefault();
                    event.returnValue = confirmationMessage;
                    return confirmationMessage;
                }
            });

            $('#printReportButton').on('click', function() {
                let data = hot.getData(); // الحصول على جميع البيانات من الجدول

                $('#dataInput').val(JSON.stringify(data));
                $('#printReportForm').submit();
            })
        });
    </script>
    @endpush
</x-front-layout>

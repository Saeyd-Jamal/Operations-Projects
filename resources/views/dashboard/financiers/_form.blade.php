<style>
    label{
        color: #000 ! important;
        font-size: 16px ! important;
    }
</style>
<div class="row">
    <div class="form-group p-3 col-4">
        <x-form.input label="الاسم" :value="$financier->name" name="name" placeholder="اسم الممول" required autofocus />
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input type="number" list="financier_numbers_list" :value="$financier->financier_number" name="financier_number" label="رقم الممول" placeholder="" required />
        <datalist id="financier_numbers_list">
            @foreach ($financier_numbers as $financier_number)
                <option value="{{$financier_number}}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input :value="$financier->stage" name="stage" label="المرحلة" placeholder="" required />
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input :value="$financier->maneger_name" name="maneger_name" label="المدير" placeholder="" />
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input type="number" step="0.01" min="0" :value="$financier->amount_ils" name="amount_ils" label="المبلغ ش" placeholder="" required />
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input type="number" min="0" :value="$financier->number_cases" name="number_cases" label="عدد الحالات" placeholder="" required />
    </div>
    <div class="form-group p-3 col-3">
        <div class="checkbox-wrapper-46">
            <input type="checkbox" id="completion_project" name="completion_project" class="inp-cbx" @checked($financier->completion_project == 1) />
            <label for="completion_project" class="cbx">
                <span>
                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg>
                </span>
                <label for="completion_project" >إنتهاء المشروع</span>
            </label>
        </div>
    </div>
    <div class="form-group p-3 col-3">
        <div class="checkbox-wrapper-46">
            <input type="checkbox" id="push_project" name="push_project" class="inp-cbx" @checked($financier->push_project == 1) />
            <label for="push_project" class="cbx">
                <span>
                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg>
                </span>
                <label for="push_project">دفع المشروع</span>
            </label>
        </div>
    </div>
    <div class="form-group p-3 col-3">
        <div class="checkbox-wrapper-46">
            <input type="checkbox" id="project_distribution" name="project_distribution" class="inp-cbx" @checked($financier->project_distribution == 1) />
            <label for="project_distribution" class="cbx">
                <span>
                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg>
                </span>
                <label for="project_distribution">توزيع المشروع</span>
            </label>
        </div>
    </div>
    <div class="form-group p-3 col-3">
        <div class="checkbox-wrapper-46">
            <input type="checkbox" id="project_archive" name="project_archive" class="inp-cbx" @checked($financier->project_archive == 1) />
            <label for="project_archive" class="cbx">
                <span>
                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg>
                </span>
                <label for="project_archive">أرشفة المشروع</span>
            </label>
        </div>
    </div>
</div>
<div class="row align-items-center mb-2">
    <div class="col">
        <h2 class="h5 page-title"></h2>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            {{ $btn_label ?? 'أضف' }}
        </button>
    </div>
</div>

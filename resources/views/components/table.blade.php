<div>
      {{config('vue-table.headers')}}

      <div id="app_datatable">
            <table-component
                 headers="{{$headers ?? 'empty'}}"
            />
      </div>
</div>
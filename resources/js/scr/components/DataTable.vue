<template>
  <div class="w-full p-4">
    <div class="relative mb-4 flex w-full flex-wrap items-stretch">
      <input
          id="datatable-search-input1"
          type="search"
          class="relative m-0 -mr-0.5 block w-[1px] min-w-0
                    flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding
                    px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition
                    duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700
                    focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600
                    dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
          placeholder="Search"
          aria-label="Search"
          aria-describedby="button-addon1"/>
    </div>
    <div class="h-1 w-full bg-neutral-200 dark:bg-neutral-600">
      <div class="h-1 text-center" :style=style :class="progressClass"></div>
    </div>
    <div id="datatable"
         data-te-rows-text="Строк на странице:"
         data-te-no-found-message="Соответствующих запросу записей не найдено."
         data-te-pagination="true"
         data-te-entries=25
         data-te-class-column="text-gray-700 py-4 text-xl dark:text-gray-200"
         data-te-class-row="text-gray-700 text-sm dark:text-gray-200"
         data-te-class-pagination="flex md:flex-row justify-start items-center
                 py-2 space-x-4 text-sm flex-col px-4 leading-[1.6] text-gray-700 dark:text-gray-200">
    </div>
  </div>


</template>

<script setup>

import {computed, onMounted, ref} from "vue";
import {Ripple, Datatable, Input, initTE} from "tw-elements";

const props = defineProps({
 headers:Object
})
const counter = ref();
const style = computed({
  get(val){
    return 'width: '+ counter.value +'%'
  },
  set(){
  }
})
const progressClass = ref('bg-primary')

onMounted(() => {
  initTE({Datatable, Ripple, Input});
  dataColumns.value = [
    {label: 'Банк/касса', field: 'name', sort: true},
    {label: 'Сумма', field: 'money', sort: true},
    {label: "Редактор", field: "edit", sort: false},
  ];
  getBank();
console.log(props.name)
});

const bank = ref('');
const dataColumns = ref();
const idRecord = ref();
const nameRecord = ref();
const idRecordEdit = ref();
const nameRecordEdit = ref();
const error = ref('');
const money = ref('0');

const setProgress = function () {
  counter.value =0
  progressClass.value='bg-red-500'
  const timer  =    setInterval(()=>{
    counter.value +=100/200
    if(counter.value>=100){
      clearInterval(timer)
    }
  },1)
}

const setWait = function (){
  counter.value = 100
  progressClass.value = 'bg-yellow-500'
}

const getBank = function () {
  setProgress();
  const data =[
    {
      "id": 8,
      "team_id": 24,
      "name": "ИП Счет",
      "money": 2158000,
      "deleted_at": null,
      "created_at": "2023-11-09T12:30:20.000000Z",
      "updated_at": "2023-11-12T15:48:49.000000Z"
    },
    {
      "id": 7,
      "team_id": 24,
      "name": "Карта",
      "money": 1465613.94,
      "deleted_at": null,
      "created_at": "2023-11-09T12:29:00.000000Z",
      "updated_at": "2023-11-12T15:52:12.000000Z"
    }
  ]
  bl(data);

  // fetch('/user/directory/bank/getBank', {
  //   method: 'GET',
  //   headers: {
  //     'Content-Type': 'application/json',
  //     "x-csrf-token": document.getElementsByTagName("meta")[0].content
  //   },
  // }).then(function (response) {
  //   setWait()
  //   return response
  // })
  //     .then((response) => response.json())
  //     .then((a) => {
  //       if (a) {
  //         bl(a.result);
  //       }
  //     }).then(()=>{
  //   progressClass.value='bg-green-500'
  // });
}


const bl = function (eb) {
  const customDatatable = document.getElementById("datatable");
  const setActions = () => {
    document.querySelectorAll(".call-btn-edit").forEach((btn) => {
      btn.addEventListener("click", () => {
        idRecordEdit.value = `${btn.attributes["data-te-id-edit"].value}`
        nameRecordEdit.value = `${btn.attributes["data-te-name-edit"].value}`
      });
    });

    document.querySelectorAll(".call-btn-delete").forEach((btn) => {
      btn.addEventListener("click", () => {
        idRecord.value = `${btn.attributes["data-te-id-delete"].value}`
        nameRecord.value = `${btn.attributes["data-te-name-delete"].value}`
      });
    });
  };

  customDatatable.addEventListener("render.te.datatable", setActions)

  const columns = dataColumns.value;
  const asyncTable = new Datatable(
      customDatatable,
      {columns},
      {loading: true}
  );

  asyncTable.update(
      {
        columns: columns,
        rows: eb.map((row) => {
          return {
            ...row,
            edit: `
            <button
              type="button"
              data-te-toggle="modal"
              data-te-target="#editBank"
              data-te-ripple-init
              data-te-ripple-color="dark"
              data-te-id-edit=${row.id}
              data-te-name-edit="${row.name}"
              class="call-btn-edit inline-block rounded-full border border-primary p-1.5 mr-1 uppercase leading-normal
              shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out
              hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
              focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
              active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
              dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)]
              dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]
              dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]
              dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
</svg>
            </button>
            <button
              type="button"
              data-te-toggle="modal"
              data-te-target="#confirmDelete"
              data-te-ripple-init
              data-te-ripple-color="light"
              data-te-id-delete=${row.id}
              data-te-name-delete="${row.name}"
              class="call-btn-delete  inline-block rounded-full border border-primary
              bg-danger text-white p-1.5 uppercase leading-normal
              shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150
              ease-in-out
              hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
              focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
              active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
              dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)]
              dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]
               dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]
               dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             class="bi bi-trash3 text-red-700" viewBox="0 0 16 16">
            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
            </svg>
            </button>`,
          };
        }),
      },
      {loading: false}
  );
  document.getElementById('datatable-search-input1').addEventListener('input', (e) => {
    asyncTable.search(e.target.value);
  });
}

</script>




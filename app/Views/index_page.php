<?php
/**
 * @var $title string Page Title
 * @var $users array Users
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Tailwind css -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    <!-- Toast lib -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" integrity="sha512-k+xZuzf4IaGQK9sSDjaNyrfwgxBfoF++7u6Q0ZVUs2rDczx9doNZkYXyyQbnJQcMR4o+IjvAcIj69hHxiOZEig==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="/storage/js/index_page.js"></script>

    <title><?= $title ?></title>
</head>
<body class="m-2">

    <div class="flex justify-between items-center mb-6 px-5 py-4 bg-white shadow-sm rounded-lg border border-gray-100">
        <h1 class="text-2xl font-bold text-gray-800">
            Управління користувачами
        </h1>
        <button command="show-modal"
                commandfor="createDialog"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-all active:scale-95 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Додати користувача
        </button>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Ім'я</th>
                <th scope="col" class="px-6 py-3">Прізвище</th>
                <th scope="col" class="px-6 py-3">Роль</th>
                <th scope="col" class="px-6 py-3">Дії</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" id="usersBody">
            </tbody>
        </table>
    </div>

    <!-- Start Create Dialog -->
    <dialog id="createDialog" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
        <el-dialog-backdrop class="fixed inset-0 bg-gray-500/75 transition-opacity"></el-dialog-backdrop>
        <div class="flex min-h-full items-center justify-center p-4">
            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Створення нового користувача</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ім'я</label>
                            <input id="create_firstName" type="text" class="mt-1 block w-full rounded-md
                                    border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2
                                    border" placeholder="Введіть Ім'я">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Прізвище</label>
                            <input id="create_lastName" type="text" class="mt-1 block w-full rounded-md
                                    border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2
                                    border" placeholder="Введіть Прізвище">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Роль</label>
                            <select id="create_roleId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button"
                            command="close"
                            commandfor="createDialog"
                            value="save"
                            class="inline-flex  w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm
                                    font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
                    >Створити</button>
                    <button type="button"
                            command="close"
                            commandfor="createDialog"
                            value="cancel"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm
                                    font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50
                                    sm:mt-0 sm:w-auto"
                    >Скасувати</button>
                </div>
            </el-dialog-panel>
        </div>
    </dialog>
    <!-- End Edit Dialog -->

    <!-- Start Edit Dialog -->
    <dialog id="deleteDialog"
            aria-labelledby="dialog-title"
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent
                    backdrop:bg-transparent"
    >
        <el-dialog-backdrop class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

        <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-red-600">
                                <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 id="dialog-title" class="text-base font-semibold text-gray-900">
                                Видалення облікового запису
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Ви впевнені що хочете видалити обліковий запис?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button"
                            command="close"
                            commandfor="deleteDialog"
                            value="confirm"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm
                                    font-semibold text-white shadow-xshover:bg-red-500 sm:ml-3 sm:w-auto"
                    >Видалити</button>

                    <button type="button"
                            command="close"
                            commandfor="deleteDialog"
                            value="cancel"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm
                                    font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50
                                    sm:mt-0 sm:w-auto"
                    >Скасувати
                    </button>
                </div>
            </el-dialog-panel>
        </div>
    </dialog>
    <!-- End Edit Dialog -->

    <!-- Start Edit Dialog -->
    <dialog id="editDialog"
            aria-labelledby="dialog-title"
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent
                    backdrop:bg-transparent"
    >
        <el-dialog-backdrop class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

        <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full
                                bg-blue-100 sm:mx-0 sm:size-10">
                            <svg class="svg-icon" style="vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M510.8 103.9c-225.5 0-408.4 182.8-408.4 408.4 0 225.5 182.8 408.4 408.4 408.4 225.5 0 408.4-182.8 408.4-408.4 0-225.5-182.8-408.4-408.4-408.4z m229.8 310.9L499.7 655.7c-6.4 6.4-14.7 9.5-23 9.5s-16.7-3.1-23-9.5L316.2 518.3c-12.7-12.7-12.7-33.2 0-45.9 12.7-12.7 33.2-12.7 45.9 0l114.5 114.5 218-218c12.7-12.7 33.2-12.7 45.9 0 12.8 12.7 12.8 33.3 0.1 45.9z" fill="#3259CE" /></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 id="dialog-title" class="text-base font-semibold text-gray-900">
                                Редагування облікового запису
                            </h3>

                            <div>
                                <label for="price" class="block text-sm/6 font-medium text-gray-900"
                                >Ім'я</label>
                                <div class="mt-2">
                                    <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                        <input id="firstName"
                                               type="text"
                                               name="firstName"
                                               placeholder="Введіть ім'я користувача"
                                               class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900
                                                placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                                    </div>

                                    <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                        <input id="lastName"
                                               type="text"
                                               name="lastName"
                                               placeholder="Введіть прізвище користувача"
                                               class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900
                                                placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                                    </div>


                                    <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                        <select id="roleId"
                                                name="roleId"
                                                class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900
                                                placeholder:text-gray-400 focus:outline-none sm:text-sm/6">
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button"
                            command="close"
                            commandfor="editDialog"
                            value="save"
                            class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm
                                    font-semibold text-white shadow-xshover:bg-blue-500 sm:ml-3 sm:w-auto"
                    >Зберегти</button>

                    <button type="button"
                            command="close"
                            commandfor="editDialog"
                            value="cancel"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm
                                    font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50
                                    sm:mt-0 sm:w-auto"
                    >Скасувати
                    </button>
                </div>
            </el-dialog-panel>
        </div>
    </dialog>
    <!-- End edit dialog !-->
</body>
</html>
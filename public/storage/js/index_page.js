let usersBody;
let rolesBody;
let rolesCreateUserBody;


document.addEventListener('DOMContentLoaded', async function() {
    usersBody = document.getElementById("usersBody");
    rolesBody = document.getElementById("roleId");
    rolesCreateUserBody = document.getElementById("create_roleId");

    const roles = await getAllRoles();

    if (roles && roles?.length > 0) {
        renderRoles(roles);
    }

    const users = await getAllUsers();

    if (users && users?.length > 0) {
        renderUsersTable(users);
    }
});

document.addEventListener('click', async (event) => {
    const deleteBtn = event.target.closest('[commandfor="deleteDialog"]');
    const editBtn = event.target.closest('[commandfor="editDialog"]');
    const createBtn = event.target.closest('[commandfor="createDialog"]');

    if (!deleteBtn && !editBtn && !createBtn) return;

    const btn = deleteBtn || editBtn || createBtn;
    if (btn.getAttribute('command') === 'close') return;

    if (createBtn) {
        document.getElementById('create_firstName').value = '';
        document.getElementById('create_lastName').value = '';

        const confirmed = await createAction();
        if (confirmed) {
            const fName = document.getElementById('create_firstName').value;
            const lName = document.getElementById('create_lastName').value;
            const rId = document.getElementById('create_roleId').value;
            await createUserRequest(fName, lName, rId);
            renderUsersTable(await getAllUsers());
        }
    }

    if (editBtn) {
        let fNameInput = document.getElementById('firstName');
        let lNameInput = document.getElementById('lastName');
        let rIdInput = document.getElementById('roleId');

        fNameInput.value = editBtn.dataset.firstName;
        lNameInput.value = editBtn.dataset.lastName;
        rIdInput.value = editBtn.dataset.roleId;

        const edited = await editAction();
        if (edited) {
            const id = editBtn.dataset.id;

            await updateUserRequest(id, fNameInput.value, lNameInput.value, rIdInput.value);
            renderUsersTable(await getAllUsers());
        }
    }

    if (deleteBtn) {
        const confirmed = await confirmAction();
        if (confirmed) {
            await removeUserRequest(deleteBtn.dataset.id);
            renderUsersTable(await getAllUsers());
        }
    }
});

async function getAllUsers() {
    try {
        const response = await fetch('/api/users', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) sendNotification('Невідома помилка');

        let result = await response.json();
        return result.data;
    } catch (err) {
        console.log('Error', err);
        return [];
    }
}

async function getAllRoles() {
    try {
        const response = await fetch('/api/roles', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) sendNotification('Невідома помилка');

        let result = await response.json();

        return result.data;
    } catch (err) {
        console.log('Error', err);
        return [];
    }
}

function sendNotification(message, type = 'success') {
    let options = {
        type: type,
        text: message,
        duration: 5000,
        newWindow: false,
        gravity: "top",
        position: 'right',
    };

    if (type !== 'success') {
        options.style = {
            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
        };
    }

    Toastify(options).showToast();
}

async function updateUserRequest(userId, firstName, lastName, roleId) {
    try {
        const response = await fetch(`/api/users`, {
            method: 'POST',
            body:  JSON.stringify({
                userId: userId,
                firstName: firstName,
                lastName: lastName,
                roleId: roleId
            })
        })

        const result = await response.json();

        if (!response.ok) {

            if (result.errors) {
                const errors = Object.values(result.errors).join("\n");
                sendNotification(errors, 'error');
                return;
            }
            throw new Error('Помилка сервера');
        }

        sendNotification('Дані користувача успішно оновлено!');
    } catch (err) {
        sendNotification('Невідома помилка: ' + err.message, 'error');
    }
}

async function removeUserRequest(userId) {
    try {
        const response = await fetch(`/api/users`, {
            method: 'DELETE',
            body:  JSON.stringify({userId: userId})
        })

        if (!response.ok) {
            sendNotification('Server error', 'error');
            return;
        }

        sendNotification('Акаунт користувача успішно видалено!');
    } catch (err) {
        sendNotification('Undefined error: ' + err.message, 'error');
    }
}

async function createUserRequest(firstName, lastName, roleId) {
    try {
        const response = await fetch('/api/users/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                firstName: firstName,
                lastName: lastName,
                roleId: roleId
            })
        });

        const result = await response.json();

        if (!response.ok) {

            if (result.errors) {
                const errors = Object.values(result.errors).join("\n");
                sendNotification(errors, 'error');
                return;
            }
            throw new Error('Помилка сервера');
        }

        sendNotification('Користувача успішно створено!');
        document.getElementById('create_firstName').value = '';
        document.getElementById('create_lastName').value = '';
    } catch (err) {
        sendNotification('Не вдалося створити: ' + err.message, 'error');
    }
}

function createAction() {
    const dialog = document.getElementById('createDialog');
    return new Promise((resolve) => {
        const handleClose = () => {
            resolve(dialog.returnValue === 'save');
            dialog.removeEventListener('close', handleClose);
        };
        dialog.addEventListener('close', handleClose, { once: true });
    });
}


function renderUsersTable(usersData) {
    usersBody.innerHTML = '';

    usersData.forEach(user => {
        const row = `
                        <tr class="hover:bg-gray-50 border-b dark:hover:bg-gray-600 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#${user.id}</td>
                            <td class="px-6 py-4">${escapeHtml(user.first_name)}</td>
                            <td class="px-6 py-4">${escapeHtml(user.last_name)}</td>
                            <td class="px-6 py-4">${escapeHtml(user.role_name)}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4 whitespace-nowrap">
                                    <button data-action="delete"
                                            data-id="${user.id}"
                                            command="show-modal"
                                            commandfor="deleteDialog"
                                            class="flex items-center justify-center"
                                    >
                                       <div 
                                          class="w-5 h-5 bg-gray-500 hover:bg-red-500 transition-colors"
                                          style="mask: url('/storage/images/icons/delete_action.svg') no-repeat center / contain; 
                                                 -webkit-mask: url('/storage/images/icons/delete_action.svg') no-repeat center / contain;"
                                        ></div>
                                     </button>
    
                                    <button data-action="edit"
                                            command="show-modal"
                                            commandfor="editDialog"
                                            data-id="${user.id}"
                                            data-first-name="${user.first_name}"
                                            data-last-name="${user.last_name}"
                                            data-role-id="${user.role_id}"
                                            class="flex items-center justify-center"
                                    >
                                       <div 
                                          class="w-5 h-5 bg-gray-500 hover:bg-blue-500 transition-colors"
                                          style="mask: url('/storage/images/icons/edit_action.svg') no-repeat center / contain; 
                                                 -webkit-mask: url('/storage/images/icons/edit_action.svg') no-repeat center / contain;"
                                        ></div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;

        usersBody.insertAdjacentHTML('beforeend', row);
    });
}

function renderRoles(rolesData) {
    const editSelect = document.getElementById("roleId");
    const createSelect = document.getElementById("create_roleId");

    const options = rolesData.map(role =>
        `<option value="${role.id}">${role.name}</option>`
    ).join('');

    if (editSelect) editSelect.innerHTML = options;
    if (createSelect) createSelect.innerHTML = options;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function editAction() {
    const dialog = document.getElementById('editDialog');

    return new Promise((resolve) => {
        const handleClose = () => {
            resolve(dialog.returnValue === 'save');
            dialog.removeEventListener('close', handleClose);
        };

        dialog.addEventListener('close', handleClose, { once: true });
    });
}

function confirmAction() {
    const dialog = document.getElementById('deleteDialog');


    return new Promise((resolve) => {
        const handleClose = () => {
            console.log("cancel");
            resolve(dialog.returnValue === 'confirm');
            dialog.removeEventListener('close', handleClose);
        };

        dialog.addEventListener('close', handleClose, { once: true });
    });
}
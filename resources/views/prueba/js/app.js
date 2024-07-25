document.addEventListener('DOMContentLoaded', () => {
    const users = JSON.parse(localStorage.getItem('users')) || [];
    const currentUser = JSON.parse(localStorage.getItem('currentUser'));

    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    const profileForm = document.getElementById('profileForm');
    const usersTable = document.getElementById('usersTable');

    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = registerForm.name.value;
            const email = registerForm.email.value;
            const password = registerForm.password.value;
            users.push({ name, email, password });
            localStorage.setItem('users', JSON.stringify(users));
            alert('User registered successfully!');
            window.location.href = 'login.html';
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = loginForm.email.value;
            const password = loginForm.password.value;
            const user = users.find(user => user.email === email && user.password === password);
            if (user) {
                localStorage.setItem('currentUser', JSON.stringify(user));
                window.location.href = 'profile.html';
            } else {
                alert('Invalid email or password');
            }
        });
    }

    if (profileForm) {
        if (currentUser) {
            profileForm.profileName.value = currentUser.name;
            profileForm.profileEmail.value = currentUser.email;

            profileForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const name = profileForm.profileName.value;
                const email = profileForm.profileEmail.value;
                currentUser.name = name;
                currentUser.email = email;
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                const userIndex = users.findIndex(user => user.email === currentUser.email);
                users[userIndex] = currentUser;
                localStorage.setItem('users', JSON.stringify(users));
                alert('Profile updated successfully!');
            });
        } else {
            window.location.href = 'login.html';
        }
    }

    if (usersTable) {
        users.forEach((user, index) => {
            const row = usersTable.insertRow();
            row.insertCell(0).innerText = user.name;
            row.insertCell(1).innerText = user.email;
            const deleteButton = document.createElement('button');
            deleteButton.innerText = 'Delete';
            deleteButton.addEventListener('click', () => {
                users.splice(index, 1);
                localStorage.setItem('users', JSON.stringify(users));
                window.location.reload();
            });
            row.insertCell(2).appendChild(deleteButton);
        });
    }
});

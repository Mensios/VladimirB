document.addEventListener('DOMContentLoaded', function() {
    setupAuthForms();
    setupFloatingTeeth();
    
    function setupAuthForms() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        if (loginForm) {
            loginForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(loginForm);
                fetch('login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showModal(data.message);
                    if (data.status === 'success') {
                        window.location.href = 'dashboard.html';
                    }
                })
                .catch(error => {
                    showModal('Произошла ошибка. Пожалуйста, попробуйте еще раз.');
                });
            });
        }

        if (registerForm) {
            registerForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const password = document.getElementById('registerPassword').value;
                const confirmPassword = document.getElementById('registerConfirmPassword').value;

                if (password !== confirmPassword) {
                    showModal('Пароли не совпадают');
                    return;
                }

                const formData = new FormData(registerForm);
                fetch('register.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showModal(data.message);
                    if (data.status === 'success') {
                        window.location.href = 'dashboard.html';
                    }
                })
                .catch(error => {
                    showModal('Произошла ошибка. Пожалуйста, попробуйте еще раз.');
                });
            });
        }
    }

    function showModal(message) {
        const modal = document.getElementById('modal');
        const modalMessage = document.getElementById('modal-message');
        const span = document.getElementsByClassName('close')[0];

        if (modal && modalMessage && span) {
            modalMessage.textContent = message;
            modal.style.display = 'block';

            span.onclick = function() {
                modal.style.display = 'none';
            };

            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            };
        }
    }

    function setupFloatingTeeth() {
        const teethContainer = document.querySelector('.floating-teeth');
        const teethImages = ['tooth1.png', 'tooth2.png', 'tooth3.png'];

        document.addEventListener('mousemove', function(e) {
            const teeth = document.querySelectorAll('.floating-teeth .tooth');
            teeth.forEach(tooth => {
                const speed = Math.random() * 5 + 1; // Random speed for each tooth
                const x = (window.innerWidth - e.pageX * speed) / 100;
                const y = (window.innerHeight - e.pageY * speed) / 100;
                tooth.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });
    }
});

// Перемещаем функцию showModal в глобальную область видимости
function showModal(message) {
    const modal = document.getElementById('modal');
    const modalMessage = document.getElementById('modal-message');
    modalMessage.textContent = message;
    modal.style.display = 'block';

    const closeModal = document.querySelector('.close');
    closeModal.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
}

// Функция для генерации уникального ID
function generateUniqueId() {
    return '_' + Math.random().toString(36).substr(2, 9);
}

// Функция для бронирования услуги
function bookService(serviceName) {
    let currentUser = JSON.parse(localStorage.getItem('currentUser')) || JSON.parse(sessionStorage.getItem('currentUser'));

    if (!currentUser) {
        alert('Пожалуйста, войдите в систему, чтобы записаться на услугу.');
        return;
    }

    let userAppointments = JSON.parse(localStorage.getItem('userAppointments')) || {};
    
    if (!userAppointments[currentUser.login]) {
        userAppointments[currentUser.login] = [];
    }

    userAppointments[currentUser.login].push({
        id: generateUniqueId(),
        service: serviceName,
        date: new Date().toLocaleDateString()
    });

    localStorage.setItem('userAppointments', JSON.stringify(userAppointments));

    // Вызываем showModal для отображения сообщения
    showModal('Вы успешно записались на ' + serviceName);
}

// Функция для отмены услуги
function cancelService(appointmentId) {
    let currentUser = JSON.parse(localStorage.getItem('currentUser')) || JSON.parse(sessionStorage.getItem('currentUser'));
    let userAppointments = JSON.parse(localStorage.getItem('userAppointments')) || {};
    
    if (userAppointments[currentUser.login]) {
        userAppointments[currentUser.login] = userAppointments[currentUser.login].filter(appointment => appointment.id !== appointmentId);
        
        localStorage.setItem('userAppointments', JSON.stringify(userAppointments));
        
        const appointmentsContainer = document.getElementById('appointmentList');
        appointmentsContainer.innerHTML = '';
        
        const currentUserAppointments = userAppointments[currentUser.login];
        
        if (currentUserAppointments.length === 0) {
            appointmentsContainer.innerHTML = '<p>У вас нет записей на услуги.</p>';
        } else {
            currentUserAppointments.forEach(appointment => {
                const div = document.createElement('div');
                div.className = 'appointment-item';
                div.innerHTML = `<p><strong>Дата:</strong> ${appointment.date}</p>
                                 <p><strong>Услуга:</strong> ${appointment.service}</p>
                                 <button class="cancel-btn" data-appointment-id="${appointment.id}">Отменить</button>`;
                appointmentsContainer.appendChild(div);
            });
        }
        
        showModal('Вы успешно отменили запись.');
    }
}

// Обработчик события загрузки контента
document.addEventListener('DOMContentLoaded', function() {
    const isTemporaryUser = sessionStorage.getItem('temporaryUser');
    const currentUser = JSON.parse(localStorage.getItem('currentUser')) || JSON.parse(sessionStorage.getItem('currentUser'));

    if (!currentUser) {
        alert('Пожалуйста, войдите в систему.');
        window.location.href = 'login.html';
        return;
    }

    document.getElementById('userName').textContent = currentUser.name;
    document.getElementById('profileLogin').textContent = currentUser.login;

    const profilePhoto = document.getElementById('profilePhoto');
    if (currentUser.avatar) {
        profilePhoto.src = currentUser.avatar;
    }
    const avatarForm = document.getElementById('avatarForm');
    avatarForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию

        const avatarInput = document.getElementById('avatarInput');
        const file = avatarInput.files[0];

        if (!file) {
            alert('Выберите файл для загрузки.');
            return;
        }

        // Создаем объект FileReader для чтения содержимого файла
        const reader = new FileReader();
        reader.onload = function() {
            const avatarDataURL = reader.result;

            // Сохраняем данные аватара в localStorage
            currentUser.avatar = avatarDataURL;
            localStorage.setItem('currentUser', JSON.stringify(currentUser));

            // Обновляем изображение профиля на странице
            profilePhoto.src = avatarDataURL;

            showModal('Аватар успешно изменён и сохранён.');
        };

        reader.readAsDataURL(file);
    });

    let userAppointments = JSON.parse(localStorage.getItem('userAppointments')) || {};
    
    const appointmentsContainer = document.getElementById('appointmentList');
    appointmentsContainer.innerHTML = '';
    
    if (userAppointments[currentUser.login]) {
        userAppointments[currentUser.login].forEach(appointment => {
            const div = document.createElement('div');
            div.className = 'appointment-item';
            div.innerHTML = `<p><strong>Дата:</strong> ${appointment.date}</p>
                             <p><strong>Услуга:</strong> ${appointment.service}</p>
                             <button class="cancel-btn" data-appointment-id="${appointment.id}">Отменить</button>`;
            appointmentsContainer.appendChild(div);
        });
    } else {
        appointmentsContainer.innerHTML = '<p>У вас нет записей на услуги.</p>';
    }

    // Добавляем обработчик события для кнопок отмены
    appointmentsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('cancel-btn')) {
            const appointmentId = event.target.getAttribute('data-appointment-id');
            cancelService(appointmentId);
        }
    });

    if (isTemporaryUser) {
        localStorage.removeItem('currentUser');
        sessionStorage.removeItem('temporaryUser');
    }
});


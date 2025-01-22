let conditionIndex = 1;

function createCondition() {

    if (conditionIndex >= 5) {
        alert('Количество правил не должно превышать 5.');
        return;
    }

    const conditionsDiv = document.getElementById('conditions');

    const newConditionDiv = document.createElement('div');
    newConditionDiv.className = 'condition-wrapper';

    const fields = JSON.parse(document.getElementById('fields-data').value);
    const operators = JSON.parse(document.getElementById('operators-data').value);

    const field = document.createElement('select');
    field.classList.add('form-control', 'form-control-sm');

    const operator = document.createElement('select');
    operator.classList.add('form-control', 'form-control-sm');

    const value = document.createElement('input');
    value.classList.add('form-control', 'form-control-sm');
    value.setAttribute('type', 'text');
    value.setAttribute('placeholder', 'Значение');

    const fieldDefaultOption = document.createElement('option');
    fieldDefaultOption.value = '';
    fieldDefaultOption.textContent = 'Сущность';
    field.appendChild(fieldDefaultOption);

    for (const key in fields) {
        const option = document.createElement('option');
        option.value = key;
        option.textContent = fields[key];
        field.appendChild(option);
    }

    const operatorDefaultOption = document.createElement('option');
    operatorDefaultOption.value = '';
    operatorDefaultOption.textContent = 'Знак';
    operator.appendChild(operatorDefaultOption);

    for (const key in operators) {
        const option = document.createElement('option');
        option.value = key;
        option.textContent = operators[key];
        operator.appendChild(option);
    }

    field.setAttribute('name', `conditions[${conditionIndex}][field]`);
    operator.setAttribute('name', `conditions[${conditionIndex}][operator]`);
    value.setAttribute('name', `conditions[${conditionIndex}][value]`);

    newConditionDiv.appendChild(field);
    newConditionDiv.appendChild(operator);
    newConditionDiv.appendChild(value);

    const addButton = document.createElement('button');
    addButton.type = 'button';
    addButton.classList.add('btn', 'btn-success', 'btn-sm');
    addButton.textContent = '+';
    addButton.onclick = createCondition;

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'btn-m');
    removeButton.textContent = '-';
    removeButton.onclick = () => {
        newConditionDiv.remove();
        conditionIndex--;
    };

    newConditionDiv.appendChild(addButton);
    newConditionDiv.appendChild(removeButton);

    conditionsDiv.appendChild(newConditionDiv);
    conditionIndex++;
}

function removeCondition(button) {
    const parentWrapper = button.parentNode;
    if (parentWrapper.getAttribute('data-default-rule') === 'true') {
        alert('Правило по умолчанию нельзя удалить!');
    } else {
        parentWrapper.remove();
        conditionIndex--;
    }
}

document.getElementById('rule-form').addEventListener('submit', function(event) {
    const conditionWrappers = document.querySelectorAll('.condition-wrapper');
    if (conditionWrappers.length === 0) {
        event.preventDefault();
        alert('Необходимо добавить хотя бы одно условие!');
    }
});
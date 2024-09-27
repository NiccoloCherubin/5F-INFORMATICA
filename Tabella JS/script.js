    const submitBtn = document.getElementById("submit-btn");
    const nameInput = document.getElementById("name");
    const surnameInput = document.getElementById("surname");
    const resultDiv = document.getElementById("result");

    submitBtn.addEventListener("click", function(event) {
        event.preventDefault(); 
        const name = nameInput.value;
        const surname = surnameInput.value;

        //azzero scritte
        nameInput.value = "";
        surnameInput.value = "";

        // crea tabella dove inserire i nomi
        const table = document.createElement("table");
        const tableBody = document.createElement("tbody");
        const tableRow = document.createElement("tr");
        const tableName = document.createElement("td");
        const tableSurname = document.createElement("td");

        //scrivo nella tabella
        tableName.textContent = name;
        tableSurname.textContent = surname;

        tableRow.appendChild(tableName);
        tableRow.appendChild(tableSurname);
        tableBody.appendChild(tableRow);
        table.appendChild(tableBody);

        resultDiv.appendChild(table);
    });
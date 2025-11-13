
    const form = document.getElementById('diagnosisForm');
    const button = form?.querySelector('.submit');
    const input = document.getElementById('drugInput');
    const addDrugBtn = document.getElementById('addDrug');
    const drugList = document.getElementById('drugList');
    const suggestionsBox = document.getElementById('suggestions');

    document.querySelectorAll('.test-type-label').forEach(label => {
        label.addEventListener('click', () => {
            document.querySelectorAll('.test-type-label').forEach(l => l.classList.remove('active'));
            label.classList.add('active');
        });
    });

    let suggestionIndex = -1; 

    input?.addEventListener('input', () => {
        const q = input.value.trim().toLowerCase();
        suggestionsBox.innerHTML = '';
        suggestionIndex = -1;

        if (!q) return suggestionsBox.classList.add('d-none');

        const matches = allDrugs.filter(d => d.toLowerCase().includes(q));
        if (!matches.length) return suggestionsBox.classList.add('d-none');

        suggestionsBox.classList.remove('d-none');

        matches.forEach((drug, index) => {
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = drug;
            div.dataset.index = index;

            div.onclick = () => {
                suggestionsBox.classList.add('d-none');
                addDrugToTable(drug);
                input.value = '';
            };

            suggestionsBox.appendChild(div);
        });
    });

    input?.addEventListener('keydown', (e) => {
        const items = suggestionsBox.querySelectorAll('.suggestion-item');

        // ↓ Down Arrow
        if (e.key === 'ArrowDown' && items.length) {
            e.preventDefault();
            suggestionIndex = (suggestionIndex + 1) % items.length;
        }

        // ↑ Up Arrow
        if (e.key === 'ArrowUp' && items.length) {
            e.preventDefault();
            suggestionIndex = (suggestionIndex - 1 + items.length) % items.length;
        }

        items.forEach((el, idx) => {
            el.classList.toggle('active', idx === suggestionIndex);
        });

        if (e.key === 'Tab' && items.length) {
            e.preventDefault();
            suggestionIndex = 0;
            items[0].classList.add('active');
        }

        if (e.key === 'Enter' && suggestionIndex >= 0) {
            e.preventDefault();
            const selectedDrug = items[suggestionIndex].textContent.trim();
            addDrugToTable(selectedDrug);
            input.value = '';
            suggestionsBox.classList.add('d-none');
            suggestionIndex = -1;
        }

    });

    function addDrugToForm(drug) {
        const normalizedDrug = drug.trim();

        if (!normalizedDrug) return;

        const exists = Array.from(drugList.querySelectorAll('.drug-item span'))
            .some(el => el.textContent.trim() === normalizedDrug);

        if (exists) {
            alert('هذا الدواء مضاف مسبقًا!');
            return;
        }

        const id = 'drug-' + Date.now();
        drugList.insertAdjacentHTML('beforeend', `
            <div class="col-md-6" id="${id}">
                <div class="drug-item">
                    <span>${normalizedDrug}</span>
                    <button type="button" class="btn btn-sm btn-danger" onclick="document.getElementById('${id}').remove()">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </div>
            </div>
        `);
    }

    function addDrugToTable(drug) {
        document.getElementById('drugTable').classList.remove('d-none');
        const normalizedDrug = drug.trim();
        if (!normalizedDrug) return;

        const exists = Array.from(document.querySelectorAll('#drugRows tr td:first-child'))
            .some(el => el.textContent.trim() === normalizedDrug);

        if (exists) {
            alert('هذا الدواء مضاف مسبقًا!');
            return;
        }

        const id = 'drug-' + Date.now();

        const row = `
            <tr id="${id}">
                <td>${normalizedDrug}<input type="hidden" name="drugs[${id}][name]" value="${normalizedDrug}"></td>
                <td><input type="text" class="form-control" name="drugs[${id}][dose]" placeholder="مثل قرص واحد مرتين يومياً"></td>
                <td><input type="text" class="form-control" name="drugs[${id}][duration]" placeholder="مثال: 5 أيام"></td>
                <td>
                    <select class="form-control" name="drugs[${id}][form]">
                        <option value="">اختر...</option>
                        <option value="tablet">قرص</option>
                        <option value="syrup">شراب</option>
                        <option value="injection">حقنة</option>
                        <option value="capsule">كبسولة</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="drugs[${id}][instructions]" placeholder="تعليمات الاستخدام"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="document.getElementById('${id}').remove()">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </td>
            </tr>
        `;

        document.getElementById('drugRows').insertAdjacentHTML('beforeend', row);
    }

    addDrugBtn?.addEventListener('click', () => {
        const drug = input.value.trim();
        if (!drug) return;
        addDrugToTable(drug);
        input.value = '';
        suggestionsBox.classList.add('d-none');
    });
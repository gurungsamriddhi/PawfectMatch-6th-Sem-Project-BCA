document.addEventListener('DOMContentLoaded', () => {
    // Existing code (area select, checkboxes, contact input error hiding)
    const areaSelect = document.getElementById('volInterest');
    const checkboxes = document.querySelectorAll('input[name="availability_days[]"]');
    const areaError = document.getElementById('areaError');

    if (areaSelect) {
        areaSelect.addEventListener('change', () => {
            const selectedValue = areaSelect.value;
            if (selectedValue !== '') {
                areaSelect.classList.remove('is-invalid');
                if (areaError) areaError.style.display = 'none';
            }
        });
    }

    checkboxes.forEach(box => {
        box.addEventListener('change', () => {
            const checkedCount = [...checkboxes].filter(c => c.checked).length;
            if (checkedCount > 0) {
                const availError = document.getElementById('availabilityDaysError');
                if (availError) availError.style.display = 'none';
            }
        });
    });

    const contactInput = document.getElementById('contactNumber');
    if (contactInput) {
        contactInput.addEventListener('input', () => {
            contactInput.classList.remove('is-invalid');
            const next = contactInput.parentElement.querySelector('.invalid-feedback');
            if (next) next.style.display = 'none';
        });
    }

    // New Province-City Dropdown JS
    const provincesCities = {
        "Province 1": ["Biratnagar", "Dharan", "Dhankuta", "Illam", "Morang", "Sunsari"],
        "Province 2": ["Janakpur", "Birgunj", "Rajbiraj", "Jaleshwar", "Bardibas"],
        "Bagmati Province": ["Kathmandu", "Lalitpur", "Bhaktapur", "Hetauda", "Madhyapur Thimi"],
        "Gandaki Province": ["Pokhara", "Baglung", "Gorkha", "Damauli", "Besisahar"],
        "Lumbini Province": ["Butwal", "Bhairahawa", "Gulmi", "Kapilvastu", "Dang"],
        "Karnali Province": ["Birendranagar", "Jumla", "Dolpa", "Surkhet", "Mugu"],
        "Sudurpashchim Province": ["Dhangadhi", "Tikapur", "Mahendranagar", "Baitadi", "Dadeldhura"]
    };

    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');

    function populateCities(province) {
        citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';
        if (!province || !(province in provincesCities)) return;

        provincesCities[province].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }

    provinceSelect?.addEventListener('change', () => {
        populateCities(provinceSelect.value);
        citySelect.classList.remove('is-invalid');
        const feedback = citySelect.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.style.display = 'none';
    });

    citySelect?.addEventListener('change', () => {
        citySelect.classList.remove('is-invalid');
        const feedback = citySelect.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.style.display = 'none';
    });

    // Prefill old values if available
    const oldProvince = "<?= addslashes($old['province'] ?? '') ?>";
    const oldCity = "<?= addslashes($old['city'] ?? '') ?>";
    if (oldProvince) {
        provinceSelect.value = oldProvince;
        populateCities(oldProvince);
        if (oldCity) {
            citySelect.value = oldCity;
        }
    }
});

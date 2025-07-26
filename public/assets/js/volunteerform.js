document.addEventListener("DOMContentLoaded", () => {
  // Existing code (area select, checkboxes, contact input error hiding)
  const areaSelect = document.getElementById("volInterest");
  const checkboxes = document.querySelectorAll(
    'input[name="availability_days[]"]'
  );

  const areaError = document.getElementById("areaError");

  if (areaSelect) {
    areaSelect.addEventListener("change", () => {
      const selectedValue = areaSelect.value;
      if (selectedValue !== "") {
        areaSelect.classList.remove("is-invalid");
        if (areaError) areaError.style.display = "none";
      }
    });
  }

  checkboxes.forEach((box) => {
    box.addEventListener("change", () => {
      const checkedCount = [...checkboxes].filter((c) => c.checked).length;
      if (checkedCount > 0) {
        const availError = document.getElementById("availabilityDaysError");
        if (availError) availError.style.display = "none";
      }
    });
  });

  const contactInput = document.getElementById("contactNumber");
  if (contactInput) {
    contactInput.addEventListener("input", () => {
      contactInput.classList.remove("is-invalid");
      const next =
        contactInput.parentElement.querySelector(".invalid-feedback");
      if (next) next.style.display = "none";
    });
  }

  const addressline1 = document.getElementById("addressLine1");
  if (addressline1) {
    addressline1.addEventListener("input", () => {
      addressline1.classList.remove("is-invalid");
      const next =
        addressline1.parentElement.querySelector(".invalid-feedback");
      if (next) next.style.display = "none";
    });
  }
  const addressline2 = document.getElementById("addressLine2");
  if (addressline2) {
    addressline2.addEventListener("input", () => {
      addressline2.classList.remove("is-invalid");
      const next =
        addressline2.parentElement.querySelector(".invalid-feedback");
      if (next) next.style.display = "none";
    });
  }

  const postalcode = document.getElementById("postalCode");
  if (postalcode) {
    postalcode.addEventListener("input", () => {
      postalcode.classList.remove("is-invalid");
      const next = postalcode.parentElement.querySelector(".invalid-feedback");
      if (next) next.style.display = "none";
    });
  }

  const provinceSelect = document.getElementById("province");
  const citySelect = document.getElementById("city");

  function populateCities(province) {
    citySelect.innerHTML =
      '<option value="" disabled selected>Select City</option>';
    if (!province || !(province in provincesCities)) return;

    provincesCities[province].forEach((city) => {
      const option = document.createElement("option");
      option.value = city;
      option.textContent = city;
      citySelect.appendChild(option);
    });
    if (oldCity) {
      citySelect.value = oldCity;
    }
  }

  provinceSelect?.addEventListener("change", () => {
    populateCities(provinceSelect.value);
    provinceSelect.classList.remove("is-invalid");
    const provinceError = document.getElementById("provinceError");

    if (provinceError) provinceError.style.display = "none";
    citySelect.classList.remove("is-invalid");

    const feedback =
      citySelect.parentElement.querySelector(".invalid-feedback");

    if (feedback) feedback.style.display = "none";
  });

  citySelect?.addEventListener("change", () => {
    citySelect.classList.remove("is-invalid");
    const feedback =
      citySelect.parentElement.querySelector(".invalid-feedback");

    if (feedback) feedback.style.display = "none";
  });

  if (oldProvince) {
    provinceSelect.value = oldProvince;
    populateCities(oldProvince);
   
  }
});

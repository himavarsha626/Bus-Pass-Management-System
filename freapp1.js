document.getElementById('district').addEventListener('change', function() {
  const mandalSelect = document.getElementById('mandal');
  mandalSelect.innerHTML = '<option value="">Select Mandal</option>'; // Reset mandal options

  const mandals = {
    chittoor: ['Tirupati', 'Madanapalle', 'Punganur'],
    krishna: ['Vijayawada', 'Machilipatnam', 'Gudivada'],
    guntur: ['Guntur City', 'Tenali', 'Narasaraopet']
  };

  const selectedDistrict = this.value;
  if (mandals[selectedDistrict]) {
    mandals[selectedDistrict].forEach(mandal => {
      const option = document.createElement('option');
      option.value = mandal.toLowerCase();
      option.textContent = mandal;
      mandalSelect.appendChild(option);
    });
  }
});

document.getElementById('busPassForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const photoInput = document.getElementById('photo');
  if (!photoInput.files.length) {
    alert('Please upload a passport photo.');
    return;
  }

  alert('Bus Pass Application Submitted Successfully!');
});
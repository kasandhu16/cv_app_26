// Live Preview JavaScript for CV Creator

function updatePreview() {
    const form = document.getElementById('cv-form');
    if (!form) return;

    const formData = new FormData(form);
    const cvData = {
        personal_info: {
            full_name: formData.get('personal_info[full_name]') || '',
            email: formData.get('personal_info[email]') || '',
            phone: formData.get('personal_info[phone]') || '',
            website: formData.get('personal_info[website]') || '',
            linkedin: formData.get('personal_info[linkedin]') || '',
            address: formData.get('personal_info[address]') || '',
            summary: formData.get('personal_info[summary]') || ''
        },
        work_experience: [],
        education: [],
        skills: []
    };

    // Collect work experience
    const workItems = document.querySelectorAll('.work-experience-item');
    workItems.forEach(item => {
        const jobTitle = item.querySelector('input[name$="[job_title]"]')?.value || '';
        const company = item.querySelector('input[name$="[company]"]')?.value || '';
        const location = item.querySelector('input[name$="[location]"]')?.value || '';
        const startDate = item.querySelector('input[name$="[start_date]"]')?.value || '';
        const endDate = item.querySelector('input[name$="[end_date]"]')?.value || '';
        const current = item.querySelector('input[name$="[current]"]')?.checked || false;
        const description = item.querySelector('textarea[name$="[description]"]')?.value || '';

        if (jobTitle || company) {
            cvData.work_experience.push({
                job_title: jobTitle,
                company: company,
                location: location,
                start_date: startDate,
                end_date: endDate,
                current: current,
                description: description
            });
        }
    });

    // Collect education
    const educationItems = document.querySelectorAll('.education-item');
    educationItems.forEach(item => {
        const degree = item.querySelector('input[name$="[degree]"]')?.value || '';
        const school = item.querySelector('input[name$="[school]"]')?.value || '';
        const graduationDate = item.querySelector('input[name$="[graduation_date]"]')?.value || '';

        if (degree || school) {
            cvData.education.push({
                degree: degree,
                school: school,
                graduation_date: graduationDate
            });
        }
    });

    // Collect skills
    const skillItems = document.querySelectorAll('.skill-item input[name="skills[]"]');
    skillItems.forEach(item => {
        const skill = item.value.trim();
        if (skill) {
            cvData.skills.push({
                name: skill,
                level: 'Intermediate' // Default level, could be enhanced to get from form
            });
        }
    });

    // Get selected template
    const templateId = formData.get('template_id') || 1;

    // Send AJAX request to preview endpoint
    fetch('preview', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cv_data: cvData,
            template_id: templateId
        })
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('cv-preview').innerHTML = html;
    })
    .catch(error => {
        console.error('Preview update failed:', error);
        document.getElementById('cv-preview').innerHTML = '<p class="error">Preview temporarily unavailable</p>';
    });
}

// Debounce function to limit API calls
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initial preview load
    setTimeout(updatePreview, 100);
});
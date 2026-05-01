// Form Handling JavaScript for CV Creator

document.addEventListener('DOMContentLoaded', function() {
    initFormHandlers();
});

function initFormHandlers() {
    // Add work experience
    const addWorkBtn = document.getElementById('add-work-experience');
    if (addWorkBtn) {
        addWorkBtn.addEventListener('click', addWorkExperience);
    }

    // Add education
    const addEducationBtn = document.getElementById('add-education');
    if (addEducationBtn) {
        addEducationBtn.addEventListener('click', addEducation);
    }

    // Add skill
    const addSkillBtn = document.getElementById('add-skill');
    if (addSkillBtn) {
        addSkillBtn.addEventListener('click', addSkill);
    }

    // Template change handler
    const templateRadios = document.querySelectorAll('input[name="template_id"]');
    templateRadios.forEach(radio => {
        radio.addEventListener('change', updatePreview);
    });

    // Live preview updates
    const form = document.getElementById('cv-form');
    if (form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', debounce(updatePreview, 500));
            input.addEventListener('change', debounce(updatePreview, 500));
        });
    }

    // Remove item handlers
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.preventDefault();
            e.target.closest('.work-experience-item, .education-item, .skill-item').remove();
            updatePreview();
        }
    });

    // Initial preview load
    updatePreview();
}

function addWorkExperience() {
    const container = document.getElementById('work-experience-container');
    const index = container.children.length;

    const workItem = document.createElement('div');
    workItem.className = 'work-experience-item';
    workItem.innerHTML = `
        <div class="form-row">
            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="work_experience[${index}][job_title]">
            </div>
            <div class="form-group">
                <label>Company</label>
                <input type="text" name="work_experience[${index}][company]">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="work_experience[${index}][location]">
            </div>
            <div class="form-group">
                <label>Start Date</label>
                <input type="month" name="work_experience[${index}][start_date]">
            </div>
            <div class="form-group">
                <label>End Date</label>
                <input type="month" name="work_experience[${index}][end_date]">
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="work_experience[${index}][current]"> Current</label>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="work_experience[${index}][description]" rows="3"></textarea>
        </div>
        <button type="button" class="btn btn-danger remove-item">Remove</button>
    `;

    container.appendChild(workItem);

    // Add event listeners to new inputs
    const newInputs = workItem.querySelectorAll('input, textarea');
    newInputs.forEach(input => {
        input.addEventListener('input', debounce(updatePreview, 500));
        input.addEventListener('change', debounce(updatePreview, 500));
    });
}

function addEducation() {
    const container = document.getElementById('education-container');
    const index = container.children.length;

    const eduItem = document.createElement('div');
    eduItem.className = 'education-item';
    eduItem.innerHTML = `
        <div class="form-row">
            <div class="form-group">
                <label>Degree</label>
                <input type="text" name="education[${index}][degree]">
            </div>
            <div class="form-group">
                <label>School</label>
                <input type="text" name="education[${index}][school]">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="education[${index}][location]">
            </div>
            <div class="form-group">
                <label>Graduation Date</label>
                <input type="month" name="education[${index}][graduation_date]">
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="education[${index}][description]" rows="2"></textarea>
        </div>
        <button type="button" class="btn btn-danger remove-item">Remove</button>
    `;

    container.appendChild(eduItem);

    // Add event listeners to new inputs
    const newInputs = eduItem.querySelectorAll('input, textarea');
    newInputs.forEach(input => {
        input.addEventListener('input', debounce(updatePreview, 500));
        input.addEventListener('change', debounce(updatePreview, 500));
    });
}

function addSkill() {
    const container = document.getElementById('skills-container');
    const index = container.children.length;

    const skillItem = document.createElement('div');
    skillItem.className = 'skill-item';
    skillItem.innerHTML = `
        <div class="form-row">
            <div class="form-group">
                <label>Skill Name</label>
                <input type="text" name="skills[${index}][name]">
            </div>
            <div class="form-group">
                <label>Level</label>
                <select name="skills[${index}][level]">
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                    <option value="Expert">Expert</option>
                </select>
            </div>
            <button type="button" class="btn btn-danger remove-item">Remove</button>
        </div>
    `;

    container.appendChild(skillItem);

    // Add event listeners to new inputs
    const newInputs = skillItem.querySelectorAll('input, select');
    newInputs.forEach(input => {
        input.addEventListener('input', debounce(updatePreview, 500));
        input.addEventListener('change', debounce(updatePreview, 500));
    });
}

function parseNestedFormData(formData) {
    const data = {};

    for (let [key, value] of formData.entries()) {
        const arrayMatch = key.match(/^([^\[]+)\[(\d+)\]\[(.+)\]$/);
        const objectMatch = key.match(/^([^\[]+)\[(.+)\]$/);

        if (arrayMatch) {
            const [, container, index, field] = arrayMatch;
            if (!data[container]) data[container] = [];
            if (!data[container][index]) data[container][index] = {};
            data[container][index][field] = value;
        } else if (objectMatch) {
            const [, container, field] = objectMatch;
            if (!data[container] || typeof data[container] !== 'object') data[container] = {};
            data[container][field] = value;
        } else {
            data[key] = value;
        }
    }

    return data;
}

function updatePreview() {
    const form = document.getElementById('cv-form');
    if (!form) return;

    const formData = new FormData(form);
    const data = parseNestedFormData(formData);

    // Get selected template
    const selectedTemplate = document.querySelector('input[name="template_id"]:checked');
    const templateId = selectedTemplate ? selectedTemplate.value : 1;

    // Send data to server for preview
    fetch('preview', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cv_data: data,
            template_id: templateId
        })
    })
    .then(response => response.text())
    .then(html => {
        const previewContainer = document.getElementById('cv-preview');
        if (previewContainer) {
            previewContainer.innerHTML = html;
        }
    })
    .catch(error => {
        console.error('Preview update failed:', error);
    });
}

// Debounce helper
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
<?php
// Professional Template
// $cvData is available from the including script
?>
<div class="cv-template professional-template">
    <header class="cv-header">
        <div class="personal-info">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="contact-info">
                <?php if (!empty($cvData['personal_info']['email'])): ?>
                    <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cvData['personal_info']['email']); ?></span>
                <?php endif; ?>
                <?php if (!empty($cvData['personal_info']['phone'])): ?>
                    <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($cvData['personal_info']['phone']); ?></span>
                <?php endif; ?>
                <?php if (!empty($cvData['personal_info']['website'])): ?>
                    <span><i class="fas fa-globe"></i> <?php echo htmlspecialchars($cvData['personal_info']['website']); ?></span>
                <?php endif; ?>
                <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                    <span><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank">LinkedIn</a></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($cvData['personal_info']['address'])): ?>
                <div class="address"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($cvData['personal_info']['address']); ?></div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!empty($cvData['personal_info']['summary'])): ?>
        <section class="cv-section summary-section">
            <h2 class="section-title">Professional Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($cvData['personal_info']['summary'])); ?></p>
        </section>
    <?php endif; ?>

    <?php if (!empty($cvData['work_experience'])): ?>
        <section class="cv-section">
            <h2 class="section-title">Work Experience</h2>
            <?php foreach ($cvData['work_experience'] as $exp): ?>
                <div class="work-item item-card">
                    <div class="work-header">
                        <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                        <h4><?php echo htmlspecialchars($exp['company']); ?></h4>
                        <div class="work-dates">
                            <i class="fas fa-calendar-alt"></i> <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?>
                            <?php if (!empty($exp['location'])): ?>
                                | <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($exp['location']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($exp['description'])): ?>
                        <ul class="description-list">
                            <?php 
                            $description_points = explode("\n", $exp['description']);
                            foreach ($description_points as $point) {
                                if (!empty(trim($point))) {
                                    echo '<li>' . htmlspecialchars(trim($point)) . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if (!empty($cvData['education'])): ?>
        <section class="cv-section">
            <h2 class="section-title">Education</h2>
            <?php foreach ($cvData['education'] as $edu): ?>
                <div class="education-item item-card">
                    <div class="education-header">
                        <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                        <h4><?php echo htmlspecialchars($edu['school']); ?></h4>
                        <div class="education-dates">
                            <i class="fas fa-calendar-alt"></i> <?php echo formatDate($edu['graduation_date']); ?>
                            <?php if (!empty($edu['location'])): ?>
                               | <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($edu['location']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($edu['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if (!empty($cvData['skills'])): ?>
        <section class="cv-section">
            <h2 class="section-title">Skills</h2>
            <div class="skills-list">
                <?php foreach ($cvData['skills'] as $skill): ?>
                    <div class="skill-item">
                        <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                        <div class="skill-level-bar">
                            <div class="skill-level" style="width: <?php echo getSkillLevelWidth($skill['level']); ?>;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</div>

<?php
function getSkillLevelWidth($level) {
    switch (strtolower($level)) {
        case 'beginner': return '25%';
        case 'intermediate': return '50%';
        case 'advanced': return '75%';
        case 'expert': return '100%';
        default: return '50%';
    }
}
?>

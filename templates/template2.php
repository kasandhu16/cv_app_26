<?php
// Modern Template
// $cvData is available from the including script
?>
<div class="cv-template modern-template">
    <header class="cv-header modern-header">
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
                    <span><i class="fas fa-globe"></i> <a href="<?php echo htmlspecialchars($cvData['personal_info']['website']); ?>" target="_blank">Portfolio</a></span>
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

    <div class="cv-body">
        <div class="cv-main-content">
            <?php if (!empty($cvData['personal_info']['summary'])): ?>
                <section class="cv-section">
                    <h2 class="section-title"><i class="fas fa-user"></i> Profile</h2>
                    <p><?php echo nl2br(htmlspecialchars($cvData['personal_info']['summary'])); ?></p>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2 class="section-title"><i class="fas fa-briefcase"></i> Work Experience</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="work-item modern-item">
                            <div class="item-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <div class="company"><?php echo htmlspecialchars($exp['company']); ?></div>
                            </div>
                            <div class="item-details">
                                <span class="dates"><i class="fas fa-calendar-alt"></i> <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                                <?php if (!empty($exp['location'])): ?>
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($exp['location']); ?></span>
                                <?php endif; ?>
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
        </div>

        <div class="cv-sidebar">
            <?php if (!empty($cvData['skills'])): ?>
                <section class="cv-section">
                    <h2 class="section-title"><i class="fas fa-cogs"></i> Skills</h2>
                    <div class="skills-list modern-skills">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <span class="skill-tag"><?php echo htmlspecialchars($skill['name']); ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section">
                    <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Education</h2>
                    <?php foreach ($cvData['education'] as $edu): ?>
                        <div class="education-item modern-item-sidebar">
                            <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                            <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                            <div class="dates"><?php echo formatDate($edu['graduation_date']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['languages'])): ?>
                <section class="cv-section">
                    <h2 class="section-title"><i class="fas fa-language"></i> Languages</h2>
                    <ul class="languages-list">
                        <?php foreach ($cvData['languages'] as $lang): ?>
                            <li><?php echo htmlspecialchars($lang['name']); ?> (<?php echo htmlspecialchars($lang['proficiency']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>

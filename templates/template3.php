<?php
// Creative Template
// $cvData is available from the including script
?>
<div class="cv-template creative-template">
    <header class="cv-header creative-header">
        <div class="personal-info">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="contact-info">
                <?php if (!empty($cvData['personal_info']['email'])): ?>
                    <span><?php echo htmlspecialchars($cvData['personal_info']['email']); ?></span>
                <?php endif; ?>
                <?php if (!empty($cvData['personal_info']['phone'])): ?>
                    <span><?php echo htmlspecialchars($cvData['personal_info']['phone']); ?></span>
                <?php endif; ?>
                <?php if (!empty($cvData['personal_info']['website'])): ?>
                    <span><?php echo htmlspecialchars($cvData['personal_info']['website']); ?></span>
                <?php endif; ?>
                <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                    <span><a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank"><?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?></a></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($cvData['personal_info']['address'])): ?>
                <div class="address"><?php echo htmlspecialchars($cvData['personal_info']['address']); ?></div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!empty($cvData['personal_info']['summary'])): ?>
        <section class="cv-section creative-section">
            <h2>About Me</h2>
            <p class="creative-text"><?php echo nl2br(htmlspecialchars($cvData['personal_info']['summary'])); ?></p>
        </section>
    <?php endif; ?>

    <?php if (!empty($cvData['work_experience'])): ?>
        <section class="cv-section creative-section">
            <h2>Experience</h2>
            <?php foreach ($cvData['work_experience'] as $exp): ?>
                <div class="work-item creative-item">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                        <div class="company"><?php echo htmlspecialchars($exp['company']); ?></div>
                        <div class="dates">
                            <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?>
                            <?php if (!empty($exp['location'])): ?>
                                | <?php echo htmlspecialchars($exp['location']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($exp['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if (!empty($cvData['education'])): ?>
        <section class="cv-section creative-section">
            <h2>Education</h2>
            <?php foreach ($cvData['education'] as $edu): ?>
                <div class="education-item creative-item">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                        <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                        <div class="dates">
                            <?php echo formatDate($edu['graduation_date']); ?>
                            <?php if (!empty($edu['location'])): ?>
                                | <?php echo htmlspecialchars($edu['location']); ?>
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

    <div class="creative-columns">
        <?php if (!empty($cvData['skills'])): ?>
            <section class="cv-section creative-section">
                <h2>Skills</h2>
                <div class="skills-cloud">
                    <?php foreach ($cvData['skills'] as $skill): ?>
                        <span class="skill-tag creative-tag"><?php echo htmlspecialchars($skill['name']); ?></span>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($cvData['languages'])): ?>
            <section class="cv-section creative-section">
                <h2>Languages</h2>
                <ul class="creative-list">
                    <?php foreach ($cvData['languages'] as $lang): ?>
                        <li><?php echo htmlspecialchars($lang['name']); ?> - <?php echo htmlspecialchars($lang['proficiency']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (!empty($cvData['certifications'])): ?>
            <section class="cv-section creative-section">
                <h2>Certifications</h2>
                <?php foreach ($cvData['certifications'] as $cert): ?>
                    <div class="certification-item creative-item">
                        <h3><?php echo htmlspecialchars($cert['name']); ?></h3>
                        <p><?php echo htmlspecialchars($cert['issuer']); ?> - <?php echo formatDate($cert['date']); ?></p>
                        <?php if (!empty($cert['url'])): ?>
                            <p><a href="<?php echo htmlspecialchars($cert['url']); ?>" target="_blank"><?php echo htmlspecialchars($cert['url']); ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </div>
</div>
<?php
// Business Professional Template (Premium)
?>
<div class="cv-template business-template">
    <header class="business-header">
        <div class="header-content">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="professional-title"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Business Professional'); ?></div>
            <div class="contact-bar">
                <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?></span>
                <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?></span>
                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($cvData['personal_info']['address'] ?? ''); ?></span>
                <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                <span><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank">LinkedIn</a></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="header-accent"></div>
    </header>

    <div class="business-content">
        <?php if (!empty($cvData['personal_info']['summary'])): ?>
            <section class="cv-section executive-summary">
                <h2>Executive Summary</h2>
                <p><?php echo nl2br(htmlspecialchars($cvData['personal_info']['summary'])); ?></p>
            </section>
        <?php endif; ?>

        <div class="content-grid">
            <div class="main-column">
                <?php if (!empty($cvData['work_experience'])): ?>
                    <section class="cv-section">
                        <h2>Professional Experience</h2>
                        <?php foreach ($cvData['work_experience'] as $exp): ?>
                            <div class="experience-block">
                                <div class="block-header">
                                    <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                    <div class="company-info">
                                        <span class="company"><?php echo htmlspecialchars($exp['company']); ?></span>
                                        <span class="dates"><?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                                    </div>
                                </div>
                                <?php if (!empty($exp['description'])): ?>
                                    <div class="block-content">
                                        <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>

                <?php if (!empty($cvData['education'])): ?>
                    <section class="cv-section">
                        <h2>Education</h2>
                        <?php foreach ($cvData['education'] as $edu): ?>
                            <div class="education-block">
                                <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                                <div class="school-info">
                                    <span class="school"><?php echo htmlspecialchars($edu['school']); ?></span>
                                    <span class="graduation"><?php echo formatDate($edu['graduation_date']); ?></span>
                                </div>
                                <?php if (!empty($edu['description'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>
            </div>

            <div class="sidebar-column">
                <?php if (!empty($cvData['skills'])): ?>
                    <section class="cv-section">
                        <h2>Core Competencies</h2>
                        <div class="skills-matrix">
                            <?php foreach ($cvData['skills'] as $skill): ?>
                                <div class="skill-item">
                                    <span class="skill-label"><?php echo htmlspecialchars($skill['name']); ?></span>
                                    <div class="skill-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="rating-dot <?php echo $i <= getSkillRating($skill['level']) ? 'filled' : ''; ?>"></span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if (!empty($cvData['certifications'])): ?>
                    <section class="cv-section">
                        <h2>Certifications</h2>
                        <ul class="certifications-list">
                            <?php foreach ($cvData['certifications'] as $cert): ?>
                                <li><?php echo htmlspecialchars($cert['name']); ?> - <?php echo htmlspecialchars($cert['issuer']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                <?php if (!empty($cvData['languages'])): ?>
                    <section class="cv-section">
                        <h2>Languages</h2>
                        <div class="languages-list">
                            <?php foreach ($cvData['languages'] as $lang): ?>
                                <li><?php echo htmlspecialchars($lang['name']); ?> - <?php echo htmlspecialchars($lang['proficiency']); ?></li>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.business-template { font-family: 'Times New Roman', serif; color: #2c3e50; background: #fff; }
.business-header { background: #2c3e50; color: white; padding: 40px 30px; position: relative; }
.header-content h1 { margin: 0; font-size: 2.5em; font-weight: normal; }
.professional-title { font-size: 1.2em; margin: 10px 0 20px 0; opacity: 0.9; }
.contact-bar { display: flex; gap: 30px; font-size: 0.9em; }
.contact-bar span { display: flex; align-items: center; gap: 8px; }
.contact-bar i { opacity: 0.7; }
.header-accent { position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #3498db, #2980b9, #34495e); }
.business-content { padding: 40px 30px; }
.cv-section { margin-bottom: 40px; }
.cv-section h2 { color: #2c3e50; font-size: 1.4em; margin-bottom: 20px; border-bottom: 1px solid #bdc3c7; padding-bottom: 10px; }
.executive-summary p { font-size: 1.1em; line-height: 1.6; color: #34495e; }
.content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
.experience-block, .education-block { margin-bottom: 30px; }
.block-header h3 { margin: 0 0 5px 0; color: #2c3e50; font-size: 1.1em; }
.company-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.company { color: #3498db; font-weight: bold; }
.dates { color: #7f8c8d; font-size: 0.9em; }
.block-content p { color: #555; line-height: 1.5; }
.education-block h3 { margin: 0 0 5px 0; color: #2c3e50; }
.school-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.school { color: #3498db; }
.graduation { color: #7f8c8d; font-size: 0.9em; }
.skills-matrix { display: flex; flex-direction: column; gap: 15px; }
.skill-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #ecf0f1; }
.skill-label { font-weight: 500; color: #2c3e50; }
.skill-rating { display: flex; gap: 5px; }
.rating-dot { width: 8px; height: 8px; border-radius: 50%; background: #ecf0f1; }
.rating-dot.filled { background: #3498db; }
.certifications-list, .languages-list { padding: 0; margin: 0; list-style: none; }
.certifications-list li, .languages-list li { padding: 8px 0; border-bottom: 1px solid #ecf0f1; color: #555; }
</style>
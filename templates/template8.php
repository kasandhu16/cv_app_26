<?php
// Academic Scholar Template (Premium)
?>
<div class="cv-template academic-template">
    <div class="academic-header">
        <div class="header-content">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="academic-title"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Academic Professional'); ?></div>
            <div class="contact-info">
                <span><?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?></span> |
                <span><?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?></span> |
                <span><?php echo htmlspecialchars($cvData['personal_info']['address'] ?? ''); ?></span>
                <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                | <span><a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank"><?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?></a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="academic-content">
        <?php if (!empty($cvData['personal_info']['summary'])): ?>
            <section class="cv-section">
                <h2>Academic Profile</h2>
                <p><?php echo nl2br(htmlspecialchars($cvData['personal_info']['summary'])); ?></p>
            </section>
        <?php endif; ?>

        <?php if (!empty($cvData['education'])): ?>
            <section class="cv-section">
                <h2>Education</h2>
                <?php foreach ($cvData['education'] as $edu): ?>
                    <div class="education-entry">
                        <div class="degree-line">
                            <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                            <span class="year"><?php echo formatDate($edu['graduation_date']); ?></span>
                        </div>
                        <div class="institution"><?php echo htmlspecialchars($edu['school']); ?></div>
                        <?php if (!empty($edu['description'])): ?>
                            <p><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>

        <?php if (!empty($cvData['work_experience'])): ?>
            <section class="cv-section">
                <h2>Professional Experience</h2>
                <?php foreach ($cvData['work_experience'] as $exp): ?>
                    <div class="experience-entry">
                        <div class="position-line">
                            <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                            <span class="period"><?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                        </div>
                        <div class="organization"><?php echo htmlspecialchars($exp['company']); ?></div>
                        <?php if (!empty($exp['location'])): ?>
                            <div class="location"><?php echo htmlspecialchars($exp['location']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($exp['description'])): ?>
                            <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>

        <div class="academic-columns">
            <div class="left-column">
                <?php if (!empty($cvData['skills'])): ?>
                    <section class="cv-section">
                        <h2>Research Skills & Competencies</h2>
                        <div class="skills-list">
                            <?php foreach ($cvData['skills'] as $skill): ?>
                                <span class="skill-badge"><?php echo htmlspecialchars($skill['name']); ?> (<?php echo htmlspecialchars($skill['level']); ?>)</span>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if (!empty($cvData['languages'])): ?>
                    <section class="cv-section">
                        <h2>Languages</h2>
                        <ul>
                            <?php foreach ($cvData['languages'] as $lang): ?>
                                <li><?php echo htmlspecialchars($lang['name']); ?> - <?php echo htmlspecialchars($lang['proficiency']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>
            </div>

            <div class="right-column">
                <?php if (!empty($cvData['certifications'])): ?>
                    <section class="cv-section">
                        <h2>Certifications & Awards</h2>
                        <ul>
                            <?php foreach ($cvData['certifications'] as $cert): ?>
                                <li><?php echo htmlspecialchars($cert['name']); ?> - <?php echo htmlspecialchars($cert['issuer']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.academic-template { font-family: 'Garamond', 'Times New Roman', serif; color: #2c3e50; background: #fefefe; }
.academic-header { background: linear-gradient(135deg, #8e44ad, #9b59b6); color: white; padding: 40px 30px; text-align: center; }
.academic-header h1 { margin: 0; font-size: 2.8em; font-weight: 300; }
.academic-title { font-size: 1.3em; margin: 10px 0; opacity: 0.9; }
.contact-info { font-size: 0.95em; opacity: 0.8; margin-top: 15px; }
.academic-content { padding: 40px 30px; max-width: 1000px; margin: 0 auto; }
.cv-section { margin-bottom: 35px; }
.cv-section h2 { color: #8e44ad; font-size: 1.4em; margin-bottom: 20px; border-bottom: 2px solid #8e44ad; padding-bottom: 8px; }
.education-entry, .experience-entry { margin-bottom: 25px; padding: 20px; background: #f9f9f9; border-left: 4px solid #8e44ad; }
.degree-line, .position-line { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
.degree-line h3, .position-line h3 { margin: 0; color: #2c3e50; font-size: 1.1em; }
.year, .period { color: #7f8c8d; font-size: 0.9em; font-weight: normal; }
.institution, .organization { color: #8e44ad; font-weight: 600; margin-bottom: 5px; }
.location { color: #7f8c8d; font-size: 0.9em; margin-bottom: 10px; }
.academic-columns { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
.skills-list { display: flex; flex-wrap: wrap; gap: 10px; }
.skill-badge { background: #e8e8e8; color: #2c3e50; padding: 6px 12px; border-radius: 20px; font-size: 0.85em; }
.cv-section ul { padding-left: 20px; }
.cv-section li { margin-bottom: 8px; color: #555; }
</style>
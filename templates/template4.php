<?php
// Executive Suite Template (Premium)
?>
<div class="cv-template executive-template">
    <div class="executive-header">
        <div class="name-section">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="title"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Professional Title'); ?></div>
        </div>
        <div class="contact-sidebar">
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <?php echo htmlspecialchars($cvData['personal_info']['address'] ?? ''); ?>
            </div>
            <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
            <div class="contact-item">
                <i class="fab fa-linkedin"></i>
                <?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="executive-content">
        <div class="main-content">
            <?php if (!empty($cvData['personal_info']['summary'])): ?>
                <section class="cv-section executive-summary">
                    <h2>EXECUTIVE SUMMARY</h2>
                    <p><?php echo nl2br(htmlspecialchars($cvData['personal_info']['summary'])); ?></p>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2>PROFESSIONAL EXPERIENCE</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="work-item executive-item">
                            <div class="work-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <div class="company"><?php echo htmlspecialchars($exp['company']); ?></div>
                                <div class="work-meta">
                                    <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?>
                                    <?php if (!empty($exp['location'])): ?> | <?php echo htmlspecialchars($exp['location']); ?><?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($exp['description'])): ?>
                                <ul class="achievement-list">
                                    <?php foreach (explode("\n", $exp['description']) as $achievement): ?>
                                        <?php if (trim($achievement)): ?>
                                            <li><?php echo htmlspecialchars(trim($achievement)); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </div>

        <div class="sidebar-content">
            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section sidebar-section">
                    <h2>EDUCATION</h2>
                    <?php foreach ($cvData['education'] as $edu): ?>
                        <div class="education-item">
                            <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                            <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                            <div class="edu-meta"><?php echo formatDate($edu['graduation_date']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['skills'])): ?>
                <section class="cv-section sidebar-section">
                    <h2>CORE COMPETENCIES</h2>
                    <div class="skills-grid">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <div class="skill-item">
                                <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <div class="skill-level">
                                    <div class="skill-bar" style="width: <?php echo getSkillPercentage($skill['level']); ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['certifications'])): ?>
                <section class="cv-section sidebar-section">
                    <h2>CERTIFICATIONS</h2>
                    <ul class="cert-list">
                        <?php foreach ($cvData['certifications'] as $cert): ?>
                            <li><?php echo htmlspecialchars($cert['name']); ?> (<?php echo htmlspecialchars($cert['issuer']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.executive-template { font-family: 'Georgia', serif; color: #2c3e50; }
.executive-header { background: linear-gradient(135deg, #34495e, #2c3e50); color: white; padding: 30px; display: flex; justify-content: space-between; align-items: center; }
.executive-header h1 { font-size: 2.5em; margin: 0; font-weight: 300; }
.title { font-size: 1.2em; opacity: 0.9; margin-top: 5px; }
.contact-sidebar { text-align: right; }
.contact-item { margin-bottom: 8px; }
.contact-item i { margin-right: 8px; width: 16px; }
.executive-content { display: flex; margin-top: 30px; }
.main-content { flex: 2; padding-right: 30px; }
.sidebar-content { flex: 1; }
.cv-section h2 { color: #34495e; border-bottom: 2px solid #3498db; padding-bottom: 5px; margin-bottom: 20px; }
.executive-item { margin-bottom: 25px; }
.work-header h3 { color: #2c3e50; margin: 0; font-size: 1.1em; }
.company { font-weight: bold; color: #3498db; margin: 2px 0; }
.work-meta { font-size: 0.9em; color: #7f8c8d; margin-bottom: 10px; }
.achievement-list { margin: 0; padding-left: 20px; }
.achievement-list li { margin-bottom: 5px; line-height: 1.4; }
.sidebar-section { margin-bottom: 30px; }
.education-item { margin-bottom: 15px; }
.education-item h4 { margin: 0; color: #2c3e50; }
.school { color: #3498db; font-weight: 500; }
.edu-meta { font-size: 0.9em; color: #7f8c8d; }
.skill-item { margin-bottom: 10px; }
.skill-name { display: block; font-weight: 500; margin-bottom: 3px; }
.skill-level { background: #ecf0f1; height: 6px; border-radius: 3px; overflow: hidden; }
.skill-bar { background: #3498db; height: 100%; }
.cert-list { padding: 0; list-style: none; }
.cert-list li { margin-bottom: 5px; font-size: 0.9em; }
</style>
<?php
// Startup Founder Template (Premium)
// Triggering a new deployment
?>
<div class="cv-template startup-template">
    <div class="startup-header">
        <div class="header-main">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="tagline"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Entrepreneur & Founder'); ?></div>
            <div class="mission"><?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? 'Building the future, one startup at a time'); ?></div>
        </div>
        <div class="header-metrics">
            <div class="metric">
                <span class="number">5+</span>
                <span class="label">Years Experience</span>
            </div>
            <div class="metric">
                <span class="number">3</span>
                <span class="label">Startups Founded</span>
            </div>
            <div class="metric">
                <span class="number">50+</span>
                <span class="label">Projects Completed</span>
            </div>
        </div>
    </div>

    <div class="startup-content">
        <div class="content-section">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2><i class="fas fa-rocket"></i> Entrepreneurial Journey</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="venture-card">
                            <div class="venture-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <div class="company-type"><?php echo htmlspecialchars($exp['company']); ?></div>
                            </div>
                            <div class="venture-meta">
                                <span><?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                                <?php if (!empty($exp['location'])): ?> • <?php echo htmlspecialchars($exp['location']); ?><?php endif; ?>
                            </div>
                            <?php if (!empty($exp['description'])): ?>
                                <div class="venture-description">
                                    <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section">
                    <h2><i class="fas fa-graduation-cap"></i> Foundation</h2>
                    <div class="education-list">
                        <?php foreach ($cvData['education'] as $edu): ?>
                            <div class="education-item">
                                <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                                <div class="school"><?php echo htmlspecialchars($edu['school']); ?> • <?php echo formatDate($edu['graduation_date']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <div class="sidebar-section">
            <div class="contact-card">
                <h3>Connect</h3>
                <div class="contact-links">
                    <a href="mailto:<?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?>"><i class="fas fa-envelope"></i></a>
                    <a href="tel:<?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?>"><i class="fas fa-phone"></i></a>
                    <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['website'])): ?>
                        <a href="<?php echo htmlspecialchars($cvData['personal_info']['website']); ?>" target="_blank"><i class="fas fa-globe"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($cvData['skills'])): ?>
                <div class="skills-card">
                    <h3>Superpowers</h3>
                    <div class="skills-grid">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <div class="skill-item <?php echo strtolower($skill['level']); ?>">
                                <?php echo htmlspecialchars($skill['name']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['certifications'])): ?>
                <div class="certifications-card">
                    <h3>Achievements</h3>
                    <ul>
                        <?php foreach ($cvData['certifications'] as $cert): ?>
                            <li><?php echo htmlspecialchars($cert['name']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.startup-template { font-family: 'Helvetica Neue', Arial, sans-serif; background: #fff; }
.startup-header { background: linear-gradient(135deg, #ff6b6b, #feca57); color: white; padding: 50px 30px; display: flex; justify-content: space-between; align-items: center; }
.header-main h1 { margin: 0; font-size: 2.5em; font-weight: 700; }
.tagline { font-size: 1.2em; margin: 8px 0; opacity: 0.9; }
.mission { font-size: 1em; margin-top: 15px; max-width: 400px; opacity: 0.8; }
.header-metrics { display: flex; gap: 30px; }
.metric { text-align: center; }
.number { display: block; font-size: 2em; font-weight: bold; }
.label { font-size: 0.8em; opacity: 0.8; }
.startup-content { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; padding: 40px 30px; }
.cv-section h2 { color: #333; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
.venture-card { background: #f8f9fa; border-radius: 8px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #ff6b6b; }
.venture-header h3 { margin: 0 0 5px 0; color: #333; font-size: 1.1em; }
.company-type { color: #ff6b6b; font-weight: 600; }
.venture-meta { color: #666; font-size: 0.9em; margin-bottom: 15px; }
.venture-description p { color: #555; line-height: 1.6; }
.education-list { display: flex; flex-direction: column; gap: 15px; }
.education-item h4 { margin: 0 0 3px 0; color: #333; }
.school { color: #666; font-size: 0.9em; }
.contact-card, .skills-card, .certifications-card { background: #f8f9fa; border-radius: 8px; padding: 25px; margin-bottom: 25px; }
.contact-card h3, .skills-card h3, .certifications-card h3 { margin: 0 0 20px 0; color: #333; }
.contact-links { display: flex; gap: 15px; }
.contact-links a { color: #ff6b6b; font-size: 1.5em; transition: transform 0.2s; }
.contact-links a:hover { transform: scale(1.1); }
.skills-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
.skill-item { background: #fff; padding: 8px 12px; border-radius: 20px; text-align: center; font-size: 0.85em; font-weight: 500; }
.skill-item.expert { background: #ff6b6b; color: white; }
.skill-item.advanced { background: #feca57; color: white; }
.skill-item.intermediate { background: #48dbfb; color: white; }
.certifications-card ul { padding: 0; margin: 0; list-style: none; }
.certifications-card li { padding: 8px 0; border-bottom: 1px solid #e9ecef; color: #555; }
</style>
<?php
// Marketing Pro Template (Premium)
?>
<div class="cv-template marketing-template">
    <div class="marketing-header">
        <div class="brand-section">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="brand-tagline"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Marketing Professional'); ?></div>
            <div class="brand-mission"><?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? 'Driving growth through strategic marketing'); ?></div>
        </div>
        <div class="brand-metrics">
            <div class="metric">
                <span class="metric-value">150%</span>
                <span class="metric-label">Growth Achieved</span>
            </div>
            <div class="metric">
                <span class="metric-value">50+</span>
                <span class="metric-label">Campaigns Led</span>
            </div>
            <div class="metric">
                <span class="metric-value">1M+</span>
                <span class="metric-label">Audience Reached</span>
            </div>
        </div>
    </div>

    <div class="marketing-content">
        <div class="campaigns-section">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2>Campaign Success Stories</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="campaign-card">
                            <div class="campaign-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <div class="brand"><?php echo htmlspecialchars($exp['company']); ?></div>
                            </div>
                            <div class="campaign-timeline">
                                <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?>
                            </div>
                            <?php if (!empty($exp['description'])): ?>
                                <div class="campaign-results">
                                    <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </div>

        <div class="strategy-sidebar">
            <div class="contact-card">
                <h3>Let's Collaborate</h3>
                <div class="contact-methods">
                    <a href="mailto:<?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?>" class="contact-link">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                    <a href="tel:<?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?>" class="contact-link">
                        <i class="fas fa-phone"></i> Call
                    </a>
                    <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                    <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" class="contact-link" target="_blank">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($cvData['skills'])): ?>
                <div class="skills-card">
                    <h3>Marketing Arsenal</h3>
                    <div class="skills-matrix">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <div class="skill-bar">
                                <div class="skill-label"><?php echo htmlspecialchars($skill['name']); ?></div>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?php echo getSkillPercentage($skill['level']); ?>%"></div>
                                </div>
                                <div class="skill-percentage"><?php echo getSkillPercentage($skill['level']); ?>%</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <div class="education-card">
                    <h3>Academic Foundation</h3>
                    <?php foreach ($cvData['education'] as $edu): ?>
                        <div class="education-item">
                            <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                            <div class="institution"><?php echo htmlspecialchars($edu['school']); ?></div>
                            <div class="graduation"><?php echo formatDate($edu['graduation_date']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['certifications'])): ?>
                <div class="certifications-card">
                    <h3>Professional Certifications</h3>
                    <div class="cert-badges">
                        <?php foreach ($cvData['certifications'] as $cert): ?>
                            <div class="cert-badge">
                                <span><?php echo htmlspecialchars($cert['name']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.marketing-template { font-family: 'Montserrat', sans-serif; background: #fff; }
.marketing-header { background: linear-gradient(135deg, #ff6b35, #f7931e); color: white; padding: 50px 30px; display: flex; justify-content: space-between; align-items: center; }
.brand-section h1 { margin: 0; font-size: 2.8em; font-weight: 700; }
.brand-tagline { font-size: 1.3em; margin: 10px 0; opacity: 0.9; }
.brand-mission { font-size: 1em; margin-top: 15px; max-width: 400px; opacity: 0.8; line-height: 1.4; }
.brand-metrics { display: flex; gap: 40px; }
.metric { text-align: center; }
.metric-value { display: block; font-size: 2.2em; font-weight: bold; }
.metric-label { font-size: 0.85em; opacity: 0.8; }
.marketing-content { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; padding: 40px 30px; }
.cv-section h2 { color: #333; font-size: 1.8em; margin-bottom: 30px; position: relative; }
.cv-section h2::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 60px; height: 3px; background: linear-gradient(45deg, #ff6b35, #f7931e); }
.campaign-card { background: #f8f9fa; border-radius: 10px; padding: 25px; margin-bottom: 25px; border-left: 4px solid #ff6b35; }
.campaign-header h3 { margin: 0 0 5px 0; color: #333; font-size: 1.1em; }
.brand { color: #ff6b35; font-weight: 600; }
.campaign-timeline { color: #666; font-size: 0.9em; margin-bottom: 15px; }
.campaign-results p { color: #555; line-height: 1.6; }
.contact-card, .skills-card, .education-card, .certifications-card { background: #f8f9fa; border-radius: 10px; padding: 25px; margin-bottom: 25px; }
.contact-card h3, .skills-card h3, .education-card h3, .certifications-card h3 { margin: 0 0 20px 0; color: #333; font-size: 1.2em; }
.contact-methods { display: flex; flex-direction: column; gap: 12px; }
.contact-link { display: flex; align-items: center; gap: 12px; color: #ff6b35; text-decoration: none; padding: 10px; border-radius: 6px; transition: background 0.3s; }
.contact-link:hover { background: rgba(255, 107, 53, 0.1); }
.contact-link i { width: 18px; }
.skills-matrix { display: flex; flex-direction: column; gap: 15px; }
.skill-bar { display: flex; align-items: center; gap: 15px; }
.skill-label { min-width: 120px; font-weight: 600; color: #333; }
.bar-container { flex: 1; height: 8px; background: #e9ecef; border-radius: 4px; overflow: hidden; }
.bar-fill { height: 100%; background: linear-gradient(45deg, #ff6b35, #f7931e); border-radius: 4px; }
.skill-percentage { min-width: 50px; text-align: right; font-size: 0.9em; color: #666; }
.education-item { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef; }
.education-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.education-item h4 { margin: 0 0 5px 0; color: #333; }
.institution { color: #ff6b35; font-weight: 500; }
.graduation { color: #666; font-size: 0.9em; }
.cert-badges { display: flex; flex-wrap: wrap; gap: 10px; }
.cert-badge { background: #fff; color: #333; padding: 8px 15px; border-radius: 20px; font-size: 0.85em; font-weight: 500; border: 1px solid #e9ecef; }
</style>
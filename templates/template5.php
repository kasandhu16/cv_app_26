<?php
// Tech Innovator Template (Premium)
?>
<div class="cv-template tech-template">
    <div class="tech-header">
        <div class="avatar-section">
            <div class="avatar-placeholder">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
        <div class="header-content">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="subtitle"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Technology Professional'); ?></div>
            <div class="tagline"><?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? ''); ?></div>
        </div>
    </div>

    <div class="tech-grid">
        <div class="main-panel">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2><i class="fas fa-briefcase"></i> Experience</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="experience-card">
                            <div class="card-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <div class="company-badge"><?php echo htmlspecialchars($exp['company']); ?></div>
                            </div>
                            <div class="card-meta">
                                <span class="date"><?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                                <?php if (!empty($exp['location'])): ?>
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($exp['location']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($exp['description'])): ?>
                                <div class="card-content">
                                    <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section">
                    <h2><i class="fas fa-graduation-cap"></i> Education</h2>
                    <?php foreach ($cvData['education'] as $edu): ?>
                        <div class="education-card">
                            <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                            <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                            <div class="graduation-date"><?php echo formatDate($edu['graduation_date']); ?></div>
                            <?php if (!empty($edu['description'])): ?>
                                <p><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </div>

        <div class="sidebar-panel">
            <div class="contact-card">
                <h3><i class="fas fa-address-card"></i> Contact</h3>
                <div class="contact-list">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?>
                    </div>
                    <?php if (!empty($cvData['personal_info']['website'])): ?>
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <?php echo htmlspecialchars($cvData['personal_info']['website']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($cvData['skills'])): ?>
                <div class="skills-card">
                    <h3><i class="fas fa-code"></i> Technical Skills</h3>
                    <div class="skills-cloud">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <span class="skill-chip" data-level="<?php echo htmlspecialchars($skill['level']); ?>">
                                <?php echo htmlspecialchars($skill['name']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['languages'])): ?>
                <div class="languages-card">
                    <h3><i class="fas fa-language"></i> Languages</h3>
                    <div class="language-list">
                        <?php foreach ($cvData['languages'] as $lang): ?>
                            <div class="language-item">
                                <span class="lang-name"><?php echo htmlspecialchars($lang['name']); ?></span>
                                <span class="proficiency"><?php echo htmlspecialchars($lang['proficiency']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['certifications'])): ?>
                <div class="certifications-card">
                    <h3><i class="fas fa-certificate"></i> Certifications</h3>
                    <ul class="cert-list">
                        <?php foreach ($cvData['certifications'] as $cert): ?>
                            <li><?php echo htmlspecialchars($cert['name']); ?> - <?php echo htmlspecialchars($cert['issuer']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.tech-template { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
.tech-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 30px; display: flex; align-items: center; gap: 30px; }
.avatar-placeholder { font-size: 4em; opacity: 0.8; }
.header-content h1 { margin: 0; font-size: 2.2em; font-weight: 300; }
.subtitle { font-size: 1.1em; opacity: 0.9; margin: 5px 0; }
.tagline { font-size: 0.95em; opacity: 0.8; margin-top: 10px; max-width: 400px; }
.tech-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; padding: 30px; }
.cv-section h2 { color: #333; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.cv-section h2 i { color: #667eea; }
.experience-card, .education-card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-left: 4px solid #667eea; }
.card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
.card-header h3 { margin: 0; color: #333; }
.company-badge { background: #e8f4f8; color: #667eea; padding: 4px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 500; }
.card-meta { display: flex; gap: 20px; font-size: 0.9em; color: #666; margin-bottom: 15px; }
.location i { margin-right: 5px; }
.card-content p { color: #555; line-height: 1.6; }
.education-card h3 { color: #333; margin: 0 0 5px 0; }
.school { color: #667eea; font-weight: 500; }
.graduation-date { color: #666; font-size: 0.9em; margin-bottom: 10px; }
.contact-card, .skills-card, .languages-card, .certifications-card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.contact-card h3, .skills-card h3, .languages-card h3, .certifications-card h3 { margin: 0 0 15px 0; color: #333; display: flex; align-items: center; gap: 10px; }
.contact-list { display: flex; flex-direction: column; gap: 10px; }
.contact-item { display: flex; align-items: center; gap: 10px; color: #555; }
.contact-item i { color: #667eea; width: 16px; }
.skills-cloud { display: flex; flex-wrap: wrap; gap: 8px; }
.skill-chip { background: #f0f0f0; color: #333; padding: 6px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 500; }
.skill-chip[data-level="expert"] { background: #667eea; color: white; }
.skill-chip[data-level="advanced"] { background: #764ba2; color: white; }
.skill-chip[data-level="intermediate"] { background: #f39c12; color: white; }
.language-list { display: flex; flex-direction: column; gap: 8px; }
.language-item { display: flex; justify-content: space-between; align-items: center; }
.lang-name { font-weight: 500; color: #333; }
.proficiency { color: #666; font-size: 0.9em; }
.cert-list { padding: 0; margin: 0; list-style: none; }
.cert-list li { padding: 5px 0; border-bottom: 1px solid #f0f0f0; color: #555; }
</style>
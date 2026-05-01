<?php
// Design Expert Template (Premium)
?>
<div class="cv-template design-template">
    <div class="design-header">
        <div class="hero-section">
            <div class="hero-text">
                <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
                <div class="role"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Design Professional'); ?></div>
                <div class="bio"><?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? 'Creating beautiful and functional designs'); ?></div>
            </div>
            <div class="hero-visual">
                <div class="design-elements">
                    <div class="circle"></div>
                    <div class="triangle"></div>
                    <div class="square"></div>
                    <div class="hexagon"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="design-content">
        <div class="portfolio-section">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2>Design Portfolio</h2>
                    <div class="project-grid">
                        <?php foreach ($cvData['work_experience'] as $exp): ?>
                            <div class="project-card">
                                <div class="project-header">
                                    <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                    <div class="client"><?php echo htmlspecialchars($exp['company']); ?></div>
                                </div>
                                <div class="project-meta">
                                    <span><?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                                </div>
                                <?php if (!empty($exp['description'])): ?>
                                    <div class="project-description">
                                        <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <div class="info-sidebar">
            <div class="contact-card">
                <h3>Get In Touch</h3>
                <div class="contact-details">
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
                    <?php if (!empty($cvData['personal_info']['website'])): ?>
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <?php echo htmlspecialchars($cvData['personal_info']['website']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank"><?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($cvData['skills'])): ?>
                <div class="skills-card">
                    <h3>Design Skills</h3>
                    <div class="skills-showcase">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <div class="skill-showcase">
                                <div class="skill-visual">
                                    <div class="skill-circle" style="--level: <?php echo getSkillPercentage($skill['level']); ?>%"></div>
                                </div>
                                <div class="skill-info">
                                    <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                    <span class="skill-level"><?php echo htmlspecialchars($skill['level']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <div class="education-card">
                    <h3>Education</h3>
                    <div class="education-list">
                        <?php foreach ($cvData['education'] as $edu): ?>
                            <div class="education-item">
                                <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                                <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                                <div class="year"><?php echo formatDate($edu['graduation_date']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['certifications'])): ?>
                <div class="certifications-card">
                    <h3>Certifications</h3>
                    <ul>
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
.design-template { font-family: 'Poppins', sans-serif; background: #f8f9fa; }
.design-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 30px; position: relative; overflow: hidden; }
.hero-section { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; }
.hero-text h1 { margin: 0; font-size: 3em; font-weight: 700; }
.role { font-size: 1.3em; margin: 10px 0; opacity: 0.9; }
.bio { font-size: 1em; margin-top: 15px; max-width: 500px; opacity: 0.8; line-height: 1.4; }
.hero-visual { width: 300px; height: 300px; position: relative; }
.design-elements { position: relative; width: 100%; height: 100%; }
.circle { position: absolute; width: 80px; height: 80px; border: 4px solid rgba(255,255,255,0.3); border-radius: 50%; top: 20px; left: 20px; }
.triangle { position: absolute; width: 0; height: 0; border-left: 40px solid transparent; border-right: 40px solid transparent; border-bottom: 70px solid rgba(255,255,255,0.3); bottom: 30px; right: 30px; }
.square { position: absolute; width: 60px; height: 60px; background: rgba(255,255,255,0.3); top: 50px; right: 50px; transform: rotate(45deg); }
.hexagon { position: absolute; width: 50px; height: 43px; background: rgba(255,255,255,0.3); bottom: 50px; left: 50px; clip-path: polygon(30% 0%, 70% 0%, 100% 50%, 70% 100%, 30% 100%, 0% 50%); }
.design-content { max-width: 1200px; margin: 0 auto; padding: 40px 30px; display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
.cv-section h2 { color: #333; font-size: 2em; margin-bottom: 30px; position: relative; }
.cv-section h2::after { content: ''; position: absolute; bottom: -10px; left: 0; width: 80px; height: 4px; background: linear-gradient(45deg, #667eea, #764ba2); }
.project-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; }
.project-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: transform 0.3s; }
.project-card:hover { transform: translateY(-5px); }
.project-header h3 { margin: 0 0 5px 0; color: #333; font-size: 1.2em; }
.client { color: #667eea; font-weight: 600; font-size: 0.9em; }
.project-meta { color: #666; font-size: 0.9em; margin-bottom: 15px; }
.project-description p { color: #555; line-height: 1.6; }
.contact-card, .skills-card, .education-card, .certifications-card { background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
.contact-card h3, .skills-card h3, .education-card h3, .certifications-card h3 { margin: 0 0 20px 0; color: #333; font-size: 1.3em; }
.contact-details { display: flex; flex-direction: column; gap: 15px; }
.contact-item { display: flex; align-items: center; gap: 15px; color: #555; }
.contact-item i { color: #667eea; width: 20px; }
.skills-showcase { display: flex; flex-direction: column; gap: 20px; }
.skill-showcase { display: flex; align-items: center; gap: 15px; }
.skill-visual { width: 60px; height: 60px; position: relative; }
.skill-circle { width: 100%; height: 100%; border-radius: 50%; background: conic-gradient(#667eea var(--level), #f0f0f0 0deg); position: relative; }
.skill-circle::before { content: ''; position: absolute; width: 40px; height: 40px; background: white; border-radius: 50%; top: 50%; left: 50%; transform: translate(-50%, -50%); }
.skill-info { flex: 1; }
.skill-name { display: block; font-weight: 600; color: #333; }
.skill-level { display: block; font-size: 0.8em; color: #666; text-transform: uppercase; }
.education-list { display: flex; flex-direction: column; gap: 15px; }
.education-item h4 { margin: 0 0 3px 0; color: #333; }
.school { color: #667eea; font-weight: 500; }
.year { color: #666; font-size: 0.9em; }
.certifications-card ul { padding: 0; margin: 0; list-style: none; }
.certifications-card li { padding: 8px 0; border-bottom: 1px solid #f0f0f0; color: #555; }
</style>
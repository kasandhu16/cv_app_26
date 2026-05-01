<?php
// Creative Artist Template (Premium)
?>
<div class="cv-template creative-template">
    <div class="creative-header">
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-name"><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
                <div class="hero-title"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Creative Professional'); ?></div>
                <div class="hero-quote">"<?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? 'Creating beautiful experiences through design and innovation'); ?>"</div>
            </div>
            <div class="hero-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-triangle"></div>
                <div class="decoration-square"></div>
            </div>
        </div>
    </div>

    <div class="creative-body">
        <div class="content-section">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2 class="section-title">Journey & Experience</h2>
                    <div class="timeline">
                        <?php foreach ($cvData['work_experience'] as $index => $exp): ?>
                            <div class="timeline-item <?php echo $index % 2 === 0 ? 'left' : 'right'; ?>">
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                        <div class="company"><?php echo htmlspecialchars($exp['company']); ?></div>
                                        <div class="period"><?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></div>
                                    </div>
                                    <?php if (!empty($exp['description'])): ?>
                                        <div class="timeline-description">
                                            <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section">
                    <h2 class="section-title">Education & Learning</h2>
                    <div class="education-grid">
                        <?php foreach ($cvData['education'] as $edu): ?>
                            <div class="education-card">
                                <div class="card-icon"><i class="fas fa-graduation-cap"></i></div>
                                <div class="card-content">
                                    <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                                    <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                                    <div class="year"><?php echo formatDate($edu['graduation_date']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <div class="sidebar-section">
            <div class="contact-card">
                <h3>Let's Connect</h3>
                <div class="contact-grid">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span><?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($cvData['personal_info']['address'] ?? ''); ?></span>
                    </div>
                    <?php if (!empty($cvData['personal_info']['website'])): ?>
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <span><?php echo htmlspecialchars($cvData['personal_info']['website']); ?></span>
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
                    <h3>Creative Skills</h3>
                    <div class="skills-visual">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <div class="skill-visual">
                                <div class="skill-circle" style="--percentage: <?php echo getSkillPercentage($skill['level']); ?>%">
                                    <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['languages'])): ?>
                <div class="languages-card">
                    <h3>Languages</h3>
                    <div class="language-bars">
                        <?php foreach ($cvData['languages'] as $lang): ?>
                            <div class="language-bar">
                                <div class="lang-label"><?php echo htmlspecialchars($lang['name']); ?></div>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?php echo getProficiencyPercentage($lang['proficiency']); ?>%"></div>
                                </div>
                                <div class="proficiency-label"><?php echo htmlspecialchars($lang['proficiency']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.creative-template { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%); min-height: 100vh; }
.creative-header { background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 60px 30px; position: relative; overflow: hidden; }
.hero-section { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; }
.hero-name { font-size: 3em; margin: 0; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
.hero-title { font-size: 1.5em; opacity: 0.9; margin: 10px 0; }
.hero-quote { font-size: 1.1em; font-style: italic; opacity: 0.8; margin-top: 20px; max-width: 500px; }
.hero-decoration { position: relative; width: 200px; height: 200px; }
.decoration-circle { position: absolute; width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3); border-radius: 50%; top: 20px; left: 20px; }
.decoration-triangle { position: absolute; width: 0; height: 0; border-left: 40px solid transparent; border-right: 40px solid transparent; border-bottom: 70px solid rgba(255,255,255,0.3); bottom: 30px; right: 30px; }
.decoration-square { position: absolute; width: 50px; height: 50px; background: rgba(255,255,255,0.3); transform: rotate(45deg); bottom: 20px; left: 40px; }
.creative-body { max-width: 1200px; margin: 0 auto; padding: 40px 30px; display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
.section-title { font-size: 2em; color: #333; margin-bottom: 30px; position: relative; }
.section-title::after { content: ''; position: absolute; bottom: -10px; left: 0; width: 60px; height: 4px; background: linear-gradient(45deg, #667eea, #764ba2); }
.timeline { position: relative; padding-left: 30px; }
.timeline::before { content: ''; position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: #667eea; }
.timeline-item { margin-bottom: 40px; position: relative; }
.timeline-item::before { content: ''; position: absolute; left: -22px; top: 20px; width: 12px; height: 12px; background: #667eea; border-radius: 50%; border: 3px solid white; }
.timeline-content { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
.timeline-header h3 { margin: 0 0 5px 0; color: #333; font-size: 1.2em; }
.company { color: #667eea; font-weight: 600; }
.period { color: #666; font-size: 0.9em; }
.timeline-description p { color: #555; line-height: 1.6; margin: 15px 0 0 0; }
.education-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
.education-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 20px; }
.card-icon { font-size: 2em; color: #667eea; }
.card-content h4 { margin: 0 0 5px 0; color: #333; }
.school { color: #667eea; font-weight: 500; }
.year { color: #666; font-size: 0.9em; }
.contact-card, .skills-card, .languages-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
.contact-card h3, .skills-card h3, .languages-card h3 { margin: 0 0 20px 0; color: #333; font-size: 1.3em; }
.contact-grid { display: grid; gap: 15px; }
.contact-item { display: flex; align-items: center; gap: 15px; color: #555; }
.contact-item i { color: #667eea; width: 20px; }
.skills-visual { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
.skill-circle { width: 80px; height: 80px; border-radius: 50%; background: conic-gradient(#667eea var(--percentage), #f0f0f0 0deg); display: flex; align-items: center; justify-content: center; position: relative; }
.skill-circle::before { content: ''; position: absolute; width: 60px; height: 60px; background: white; border-radius: 50%; }
.skill-name { position: relative; z-index: 1; font-size: 0.7em; font-weight: 600; text-align: center; color: #333; }
.language-bars { display: flex; flex-direction: column; gap: 15px; }
.language-bar { display: flex; align-items: center; gap: 15px; }
.lang-label { min-width: 80px; font-weight: 500; color: #333; }
.bar-container { flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px; overflow: hidden; }
.bar-fill { height: 100%; background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 4px; }
.proficiency-label { min-width: 100px; text-align: right; color: #666; font-size: 0.9em; }
</style>
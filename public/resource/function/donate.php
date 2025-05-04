<?php
function donate(){
    start('Donate', 'donate');
    echo '<main class="container">
        <div class="donate-section">
            <div class="section-header">
                <h2><span class="tech-accent">&lt;</span> Support My Work <span class="tech-accent">/&gt;</span></h2>
                <div class="tech-line"></div>
            </div>
            
            <div class="donate-content">
                <p>If you appreciate my work and would like to support me, you can donate using any of the cryptocurrency options below:</p>
                
                <div class="crypto-options">
                    <div class="crypto-item">
                        <h3>Bitcoin (BTC)</h3>
                        <div class="crypto-address">
                            <code>18cq7C3Gegea7XVnEHbXDJ9EAJ5SWFfxrZ</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'18cq7C3Gegea7XVnEHbXDJ9EAJ5SWFfxrZ\')">Copy</button>
                        </div>
                    </div>
                    
                    <div class="crypto-item">
                        <h3>Ethereum (ETH)</h3>
                        <div class="crypto-address">
                            <code>0xb23D38832c86d3A56389473D2a8cE10B684bC902</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'0xb23D38832c86d3A56389473D2a8cE10B684bC902\')">Copy</button>
                        </div>
                    </div>
                    
                    
                    
                    <div class="crypto-item">
                        <h3>Dogecoin (DOGE)</h3>
                        <div class="crypto-address">
                            <code>DSGiCuzQPXiUmvKzBrEekkb1d5bvYnsNeY</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'DSGiCuzQPXiUmvKzBrEekkb1d5bvYnsNeY\')">Copy</button>
                        </div>
                    </div>
                </div>
                
                <div class="thank-you">
                    <h3>Thank You for Your Support!</h3>
                    <p>Your donations help me continue developing and maintaining my projects.</p>
                </div>
            </div>
        </div>
    </main>';
    
    echo '<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                alert("Address copied to clipboard!");
            })
            .catch(err => {
                console.error("Could not copy text: ", err);
            });
    }
    </script>';
    
    echo '</body></html>';
}
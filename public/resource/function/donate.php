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
                            <code>bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh\')">Copy</button>
                        </div>
                    </div>
                    
                    <div class="crypto-item">
                        <h3>Ethereum (ETH)</h3>
                        <div class="crypto-address">
                            <code>0x71C7656EC7ab88b098defB751B7401B5f6d8976F</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'0x71C7656EC7ab88b098defB751B7401B5f6d8976F\')">Copy</button>
                        </div>
                    </div>
                    
                    <div class="crypto-item">
                        <h3>Tether (USDT)</h3>
                        <div class="crypto-address">
                            <code>TQVsMt6HNqm7pQd5SyHBYxpnBhXpAGRBrY</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'TQVsMt6HNqm7pQd5SyHBYxpnBhXpAGRBrY\')">Copy</button>
                        </div>
                    </div>
                    
                    <div class="crypto-item">
                        <h3>Dogecoin (DOGE)</h3>
                        <div class="crypto-address">
                            <code>D8vFz4p1L37jdg47HXKtSvC8bRBG6JaBfj</code>
                            <button class="copy-btn" onclick="copyToClipboard(\'D8vFz4p1L37jdg47HXKtSvC8bRBG6JaBfj\')">Copy</button>
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
<!-- app/views/home.php -->
<?php include 'app/views/partials/header.php'; ?>
<head>
  <link rel="stylesheet" href="/PawFectMatch/public/assets/css/style.css">
</head>


 <section id="main-hero">
    <div class="hero-section">
      <div class="hero-text">
        <h1>Every Pet Deserve a Loving Home</h1>
        <p>We've helped over 5,000 animlas find their forever families. Your new best friend is waiting to meet you.</p>
        <p style="font-size: 16px; color: #606060;">Rescue.Shelter.Adoption</p>

        <div class="btn">
          <button class="btn-primary"><i class="fas fa-paw"></i>&nbsp;Donate</button>
          <button class="btn-primary"><i class="fas fa-search"></i>&nbsp; Find Pet</button>
        </div>
      </div>
      <div class="hero-img">
        <img src="\PawfectMatch\public\assets\images\pets.png" alt="Pets Adoption" width="100%" height="400px">
        
      </div>
    </div>
  </section>

<main>
    <section id="available" aria-labelledby="available-title">
        <h2 id="available-title">Meet Our<span style="color:#008000;"> Feature Animals</span></h2>
        <p>These adorable friends are waiting for their forever homes. Could you be their perect match?</p>
        
        <div class="cards">
            <article class="card" tabindex="0" aria-label="Dog named Bella">
                <img src="https://images.unsplash.com/photo-1560807707-8cc77767d783?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60" alt="Bella the dog, a smiling golden retriever" />
                <div class="card-content">
                    <h4>Bella</h4>
                    <p>Friendly golden retriever who loves to play fetch and cuddle. Great with kids and other pets.</p>
                    <a href="#contact" class="btn-secondary" aria-label="Inquire about adopting Bella">Inquire</a>
                </div>
            </article>

            <article class="card" tabindex="0" aria-label="Cat named Luna">
                <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60" alt="Luna the cat, a beautiful tabby cat" />
                <div class="card-content">
                    <h4>Luna</h4>
                    <p>Calm and affectionate tabby cat who enjoys quiet spots and gentle pets.</p>
                    <a href="#contact" class="btn-secondary" aria-label="Inquire about adopting Luna">Inquire</a>
                </div>
            </article>
            
            <article class="card" tabindex="0" aria-label="Rabbit named Thumper">
                <img src="https://images.unsplash.com/photo-1603306485602-1af506bcc9e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60" alt="Thumper the rabbit, a fluffy white rabbit with black markings" />
                <div class="card-content">
                    <h4>Thumper</h4>
                    <p>Energetic and playful rabbit who loves carrots and hopping around the garden.</p>
                    <a href="#contact" class="btn-secondary" aria-label="Inquire about adopting Thumper">Inquire</a>
                </div>
            </article>
        </div>
    
        <section class="hero" role="banner" aria-label="Adoption call to action">
          <h2>Find Your New Best Friend Today</h2>
          <p>Adopt, don't shop! Give a homeless animal a second chance.</p>
          <a href="#available" class="btn-primary">View Pets for Adoption</a>
      </section>

    </section>
</main>
</html>
<?php include 'app/views/partials/footer.php'; ?>

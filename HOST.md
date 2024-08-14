# Host College to Akmemis

### Steps

#### 1. Setup Domain

#### 2. Setup Database

#### 3. Run SSH Agent

    eval "$(ssh-agent -s)"
    ssh-add ~/.ssh/emis_rsa

#### 4. Run Script from folder root and provide prompt params (domainName, dbName, dbUsername, dbPassword)

    sh ./.scripts/host.sh

##### hint: demo.akmemis.com => demo (domainName)

#### 5. Finally add folder for auto ci/cd in .github/workflows/akmemis.yml

Vagrant.configure("2") do |config|
  config.vm.box = "precise32"
  config.vm.box_url = "http://files.vagrantup.com/precise32.box"
  config.vm.hostname = "hydroshare.dev" # can't be hydroshare.local or the virtual apache does not work

    # solution to 'stdin: is not a tty'
    # from https://github.com/mitchellh/vagrant/issues/1673
  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

  config.vm.network :private_network, ip: "192.168.56.101"
    config.vm.network :forwarded_port, guest: 80, host: 7777
    config.ssh.forward_agent = true

  config.vm.provider :virtualbox do |v|
    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--memory", 1024]
    v.customize ["modifyvm", :id, "--name", "hydroshare-test"]
    v.customize ["modifyvm", :id, "--vrde", "on"]
    v.customize ["modifyvm", :id, "--vrdeport", "4000"]
  end



  config.vm.synced_folder "./", "/hydroshare", id: "vagrant-root"
  config.vm.provision :shell, :inline =>
    "if [[ ! -f /apt-get-run ]]; then sudo apt-get update && sudo touch /apt-get-run; fi"


  config.vm.provision :shell, :inline => 'echo -e "mysql_root_password=hydroshare_drupal
controluser_password=awesome" > /etc/phpmyadmin.facts;'

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "./hydroshare_vagrant/manifests"
    puppet.module_path = "./hydroshare_vagrant/modules"
    puppet.options = ['--verbose']
  end
end

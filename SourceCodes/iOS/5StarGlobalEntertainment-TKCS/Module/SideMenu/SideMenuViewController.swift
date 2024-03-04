//
//  SGSideMenuViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import UIKit
import SideMenu

class SideMenuViewController: UIViewController {
    //Interface
    // MARK: IBOutlets--
    @IBOutlet weak var labelEmail: UILabel!
    @IBOutlet weak var viewProfile: UIView!
    @IBOutlet weak var hieghtConstrants: NSLayoutConstraint!
    @IBOutlet weak var labelName: UILabel!
    @IBOutlet weak var imageProfile: UIImageView!
    @IBOutlet weak var sidemenuOption: UITableView!
    // MARK: Variable Initializer--
    var optionArr = [Sideoption.AboutUs, Sideoption.ContactUS, Sideoption.TermsCondintion]
    var buyerSideMenuOptionArr = [Sideoption.MyAccount, Sideoption.MyCart, Sideoption.MyOrder, Sideoption.AccountDelete, Sideoption.LogOut]
    var sections = [ItemList]()
    var items: [ItemList]?
    var UserType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes))
    var profileViewModel = ProfileViewModel()
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        self.navigationController?.isNavigationBarHidden = true
        if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 1){
            items = [
                ItemList(name: OptionAdminPromoter.User, items: [OptionAdminPromoter.ManageUser, OptionAdminPromoter.ManagePromoter]),
                ItemList(name: OptionAdminPromoter.Category, items: [OptionAdminPromoter.CreateCategory, OptionAdminPromoter.ManageCategory]),
                ItemList(name: OptionAdminPromoter.EventCharge, items: [OptionAdminPromoter.UpdateCharge]),
                ItemList(name: OptionAdminPromoter.Events, items: [OptionAdminPromoter.CreateEvents, OptionAdminPromoter.MyEVents]),
                ItemList(name: OptionAdminPromoter.EventDetails, items: [OptionAdminPromoter.Events]),
                ItemList(name: OptionAdminPromoter.MyPurchases, items: [OptionAdminPromoter.MyPurchases]),
                ItemList(name: OptionAdminPromoter.Tickets, items: [OptionAdminPromoter.CreateTicket, OptionAdminPromoter.ManageTicket]),
                ItemList(name: OptionAdminPromoter.PromotionalEvents, items: [OptionAdminPromoter.PromotionalEvents]),
                ItemList(name: OptionAdminPromoter.SubscribedUser, items: [OptionAdminPromoter.SubscriberList]),
                ItemList(name: OptionAdminPromoter.Banner, items: [OptionAdminPromoter.AddBanner, OptionAdminPromoter.ManageBanner]),
                ItemList(name: OptionAdminPromoter.Scanner, items: [OptionAdminPromoter.ScanTicket]),
                ItemList(name: Sideoption.AccountDelete, items: [Sideoption.AccountDelete])
            ]
        }else if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 3){
            items = [
                ItemList(name: OptionAdminPromoter.Events, items: [OptionAdminPromoter.CreateEvents, OptionAdminPromoter.MyEVents]),
                ItemList(name: OptionAdminPromoter.EventDetails, items: [OptionAdminPromoter.Events]),
                ItemList(name: OptionAdminPromoter.MyPurchases, items: [OptionAdminPromoter.MyPurchases]),
                ItemList(name: OptionAdminPromoter.Tickets, items: [OptionAdminPromoter.CreateTicket, OptionAdminPromoter.ManageTicket]),
                ItemList(name: OptionAdminPromoter.Scanner, items: [OptionAdminPromoter.ScanTicket]),
                ItemList(name: Sideoption.AccountDelete, items: [Sideoption.AccountDelete])
            ]
        }
        sidemenuOption.delegate = self
        sidemenuOption.dataSource = self
        
    }
    // MARK: - ViewWillAppear
    ///Create func for Profile api call
    override func viewWillAppear(_ animated: Bool) {
        setImage()
        profileDetail()
        
    }
    // MARK: Create function for Profile API Call--
    func profileDetail(){
        profileViewModel.CallProfileApi(completition: {[weak self] profileData, isSuccess in
            if isSuccess == true {
                self?.labelName.text = profileData.data?.firstName ?? DefaultValue.emptyString.rawValue
                self?.labelEmail.text = profileData.data?.email ?? DefaultValue.emptyString.rawValue
                if let imageURL = profileData.data?.userImage{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    self?.imageProfile.sd_setImage(with: URL(string: urlString),placeholderImage: UIImage(systemName: DefaultValue.imagePerson.rawValue))
                }
            }else{
//                self?.showSimpleAlert(message: profileData.message ?? DefaultValue.errorMsg.rawValue)
                debugPrint(DefaultValue.emptyString.rawValue)
            }
        })
    }
    // MARK: Create function for set Image Corner Radius--
    func setImage(){
        imageProfile.layer.borderWidth = 2.0
        imageProfile.layer.masksToBounds = false
        imageProfile.layer.borderColor = UIColor.white.cgColor
        imageProfile.layer.cornerRadius = imageProfile.frame.size.width / 2
        imageProfile.clipsToBounds = true
        
    }
}

// MARK: Create extension for tableview Delegate--
extension SideMenuViewController:UITableViewDelegate,UITableViewDataSource{
    func tableView(_ tableView: UITableView, heightForHeaderInSection section: Int) -> CGFloat {
        if section < items?.count ?? 0{
            return 40
        }else{
            return 0
        }
    }
    func tableView(_ tableView: UITableView, viewForHeaderInSection section: Int) -> UIView? {
        let headerHeading = UILabel(frame: CGRect(x: 20, y: 0, width: self.view.frame.width, height: 40))
        let imageView = UIImageView(frame: CGRect(x: self.view.frame.width - 30, y: 5, width: 20, height: 20))
        let headerView = UIView(frame: CGRect(x: 0, y: 0, width: self.view.frame.width, height: 30))
        let tapGuesture = UITapGestureRecognizer(target: self, action: #selector(headerViewTapped))
        if section < items?.count ?? 0{
            if items?[section].collapsed ?? false{
                imageView.image = UIImage(named: DefaultValue.collapsed.rawValue)
            }else{
                imageView.image = UIImage(named: DefaultValue.expand.rawValue)
            }
            tapGuesture.numberOfTapsRequired = 1
            headerView.addGestureRecognizer(tapGuesture)
            headerView.backgroundColor = UIColor.darkGray
            headerView.tag = section
            headerHeading.text = items?[section].name
            headerHeading.textColor = .white
            headerView.addSubview(headerHeading)
            headerView.addSubview(imageView)
        }
        return headerView
    }
    func numberOfSections(in tableView: UITableView) -> Int {
        if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 1) || (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 3){
            return (items?.count ?? 0) + 1
        }else{
            return 1
        }
    }
    // MARK: Function for Number of Rows in Tableview
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 1) || (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 3){
            if section < items?.count ?? 0{
                let itms = items?[section]
                return !(itms?.collapsed ?? false) ? 0 : (itms?.items.count ?? 0)
            }else{
                return 1
            }
        }else if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 2){
            return buyerSideMenuOptionArr.count
        }else{
            return optionArr.count
        }
    }
    // MARK: - Function Cell for Row at in Tableview
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        
        let cell = sidemenuOption.dequeueReusableCell(withIdentifier: SideMenuOptionTableViewCell.identifier) as! SideMenuOptionTableViewCell
        if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 1) || (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 3){
            if indexPath.section < items?.count ?? 0{
                cell.labelName?.text = items?[indexPath.section].items[indexPath.row]
            }else{
                cell.labelName?.text = DefaultValue.logOut.rawValue
            }
        }else if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 2){
            cell.labelName?.text = buyerSideMenuOptionArr[indexPath.row]
        }else{
            cell.labelName?.text = optionArr[indexPath.row]
        }
        return cell
    }
    func tableView(_ tableView: UITableView, heightForFooterInSection section: Int) -> CGFloat {
        return 0
    }
    // MARK: - Create function for didSelect Row at in Tableview
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        
        _ = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int ?? 0)
        if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 1) || (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 3){
            if indexPath.section < items?.count ?? 0{
                if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 1){
                    switch indexPath.section {
                    case 0:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageUserViewController.identifier) as! ManageUserViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                            
                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManagePromoterViewController.identifier) as! ManagePromoterViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                        default:
                            return
                        }
                    case 1:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: AddCategoryViewController.identifier) as! AddCategoryViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                            
                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageCategoryViewController.identifier) as! ManageCategoryViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                        default:
                            return
                        }
                    case 2:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: UpdateEventChargeViewController.identifier) as! UpdateEventChargeViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                        
                    case 3:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: CreateEventViewController.identifier) as! CreateEventViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                            
                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageEventViewController.identifier) as! ManageEventViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 4:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: EventOrderViewController.identifier) as! EventOrderViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 5:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: MyOrdersController.identifier) as! MyOrdersController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 6:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: CreateTicketViewController.identifier) as! CreateTicketViewController
                            self.navigationController?.pushViewController(vc , animated: true)

                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageTicketViewController.identifier) as! ManageTicketViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 7:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: PromotionalEventViewController.identifier) as! PromotionalEventViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 8:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: SubscriberListViewController.identifier) as! SubscriberListViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                        
                    case 9:
                        switch indexPath.row{
                        case 0:
                            
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: AddBannerViewController.identifier) as! AddBannerViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                            
                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageBannerImagesViewController.identifier) as! ManageBannerImagesViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 10:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ScannerViewController.identifier) as! ScannerViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 11:
                        switch indexPath.row{
                        case 0:
                            deleteAccount()
                        default:
                            return
                        }
                    default:
                        return
                    }
                }else if(UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 3){
                    switch indexPath.section {
                    case 0:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: CreateEventViewController.identifier) as! CreateEventViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                            
                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageEventViewController.identifier) as! ManageEventViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                        default:
                            return
                        }
                    case 1:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: EventOrderViewController.identifier) as! EventOrderViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 2:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: MyOrdersController.identifier) as! MyOrdersController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                        
                    case 3:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: CreateTicketViewController.identifier) as! CreateTicketViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                            
                        case 1:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ManageTicketViewController.identifier) as! ManageTicketViewController
                            self.navigationController?.pushViewController(vc, animated: true)
                        default:
                            return
                        }
                    case 4:
                        switch indexPath.row{
                        case 0:
                            let vc = self.storyboard?.instantiateViewController(withIdentifier: ScannerViewController.identifier) as! ScannerViewController
                            self.navigationController?.pushViewController(vc , animated: true)
                        default:
                            return
                        }
                    case 5:
                        switch indexPath.row{
                        case 0:
                            deleteAccount()
                        default:
                            return
                        }
                    default:
                        return
                    }
                }
            }else{
                logOutFromSideMenu()
            }
        }else if (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int == 2){
            switch indexPath.row {
            case 0:
                let vc = AppDelegate.sharedInstance.storyBoard.instantiateViewController(withIdentifier:FSGHomeTabBarController.identifier) as! FSGHomeTabBarController
                vc.selectedIndex = 1
                let navigation = UINavigationController.init(rootViewController: vc)
                navigation.setNavigationBarHidden(true, animated: false)
                SceneDelegate.shared?.window?.rootViewController = navigation
                
            case 1:
                let vc = AppDelegate.sharedInstance.storyBoard.instantiateViewController(withIdentifier:FSGHomeTabBarController.identifier) as! FSGHomeTabBarController
                vc.selectedIndex = 2
                let navigation = UINavigationController.init(rootViewController: vc)
                navigation.setNavigationBarHidden(true, animated: false)
                SceneDelegate.shared?.window?.rootViewController = navigation
            case 2:
                let vc = AppDelegate.sharedInstance.storyBoard.instantiateViewController(withIdentifier:FSGHomeTabBarController.identifier) as! FSGHomeTabBarController
                vc.selectedIndex = 3
                let navigation = UINavigationController.init(rootViewController: vc)
                navigation.setNavigationBarHidden(true, animated: false)
                SceneDelegate.shared?.window?.rootViewController = navigation
            case 3:
                deleteAccount()
            case 4:
                logOutFromSideMenu()
            default:
                return
            }
        }else{
            if indexPath.row == 1{
                let vc = self.storyboard?.instantiateViewController(withIdentifier: ContactUsViewController.identifier) as! ContactUsViewController
                self.navigationController?.pushViewController(vc, animated: true)
            }else if indexPath.row == 0{
                let vc = self.storyboard?.instantiateViewController(withIdentifier: AboutUsViewController.identifier) as! AboutUsViewController
                self.navigationController?.pushViewController(vc, animated: true)
            }else if indexPath.row == 2{
                let vc = self.storyboard?.instantiateViewController(withIdentifier: TermsConditionViewController.identifier) as! TermsConditionViewController
                self.navigationController?.pushViewController(vc, animated: true)
            }
        }
    }
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 40
    }
    // MARK: - Create function for collapsed and hide cells
    @objc func headerViewTapped(tapped:UITapGestureRecognizer){
        if items?[tapped.view!.tag].collapsed == true{
            items?[tapped.view!.tag].collapsed = false
        }else{
            items?[tapped.view!.tag].collapsed = true
        }
        if let imView = tapped.view?.subviews[1] as? UIImageView{
            if imView.isKind(of: UIImageView.self){
                if (items?[tapped.view!.tag].collapsed) ?? false{
                    imView.image = UIImage(named: DefaultValue.collapsed.rawValue)
                }else{
                    imView.image = UIImage(named: DefaultValue.expand.rawValue)
                }
            }
        }
        self.sidemenuOption.reloadData()
    }
    // MARK: - Create function for Delete Account
    func deleteAccount(){
        _ = UserDefaults.standard.string(forKey: Tokenkey.userLogin) ?? DefaultValue.emptyString.rawValue
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeletAccount, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            self.startIndicatingActivity()
            DispatchQueue.main.asyncAfter(deadline: .now() + 3, execute: {
                self.stopIndicatingActivity()
                let alert1 = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteConfirm, preferredStyle: UIAlertController.Style.alert)
                alert1.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.cancel, handler: { action in
                    UserDefaults.standard.setValue(DefaultValue.emptyString.rawValue, forKey: Tokenkey.userLogin)
                    UserDefaults.standard.setValue( 0, forKey: Tokenkey.UsersTypes)
                    AppDelegate.sharedInstance.showLogin()
                }))

                    self.present(alert1, animated: true, completion: nil)
            })
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    
    
    
    // MARK: - Create function for logout
    func logOutFromSideMenu(){
        _ = UserDefaults.standard.string(forKey: Tokenkey.userLogin) ?? DefaultValue.emptyString.rawValue
        //             self.fsgHomeViewModel.CallLogoutApi(token: userToken) { [weak self] result, status in
        //                 if result.statusCode == 200 {
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.logoutMessage, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            UserDefaults.standard.setValue(DefaultValue.emptyString.rawValue, forKey: Tokenkey.userLogin)
            UserDefaults.standard.setValue( 0, forKey: Tokenkey.UsersTypes)
            AppDelegate.sharedInstance.showLogin()
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
}
// MARK: - create structure for side menu options
struct ItemList {
    var name: String
    var items: [String]
    var collapsed: Bool
    
    init(name: String, items: [String], collapsed: Bool = false) {
        self.name = name
        self.items = items
        self.collapsed = collapsed
    }
}

//
//  HomeVC.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import UIKit
import SDWebImage
import IQKeyboardManagerSwift

class HomeViewController: UIViewController{
    //Interface
    // MARK: OUTLETS
    @IBOutlet weak var labelNoData: UILabel!
    @IBOutlet weak var viewDate: UIView!
    @IBOutlet weak var searchBarView: UIView!
    @IBOutlet weak var subscribeTextField: UITextField!
    @IBOutlet weak var searchbarTextfield: UITextField!
    @IBOutlet weak var datetextField: UITextField!
    @IBOutlet weak var pageControl: UIPageControl!
    @IBOutlet weak var loginSignUpButton: UIButton!
    @IBOutlet weak var searchButton: UIButton!
    @IBOutlet weak var suscribeButton: UIButton!
    @IBOutlet weak var viewSuscribe: GradientBackgroundView!
    @IBOutlet weak var viewLoginSignup: GradientBackgroundView!
    @IBOutlet weak var popularEventHeight: NSLayoutConstraint!
    @IBOutlet weak var collectionViewHCons: NSLayoutConstraint!
    @IBOutlet weak var collectionViewBanner: UICollectionView!
    @IBOutlet weak var eventCatagoryCollectionView: UICollectionView!
    @IBOutlet weak var collectionViewCategorySelection: UICollectionView!
    @IBOutlet weak var popularEvenTableView: UITableView!
    
    
    // MARK: VARRIABLES initializers--
    var fsgHomeViewModel = HomeViewModel()
    var contactusViewModel = ContactUsViewModel()
    var profileViewModel = ProfileViewModel()
    var viewDates = UIDatePicker()
    var currentIndex = 0
    var catID : Int = 0
    var timer:Timer?
    var timeStamp:Int?
    var date:String?
    var homeData : HomePage?
    var categorydata: [CategorySearchData]?
    var eventData: [Event] = []
    var category =  [String]()
    var changeDate = DateFormate()
    var selectedIndexPath = Int()
    var index = Int()
    var userToken = UserDefaults.standard.string(forKey: Tokenkey.userLogin)
    var isAllCategorySelected = true
    // MARK: Life cycle methods
    override func viewDidLoad() {
        super.viewDidLoad()
        
        //set palceholde text for search bar and date textFiled
        self.searchbarTextfield.placeholderCostomization(placeHolderText: AppMessage.shared.SearchText)
        self.datetextField.placeholderCostomization(placeHolderText: AppMessage.shared.DateText)
        timer = Timer.scheduledTimer(timeInterval: 5.0, target: self, selector: #selector(slideToNext), userInfo: nil, repeats: true)
        viewSuscribe.layer.maskedCorners = [.layerMaxXMaxYCorner, .layerMaxXMinYCorner]
        loginSignUpButton.layer.cornerRadius = 10
        collectionViewCategorySelection.delegate = self
        collectionViewCategorySelection.dataSource = self
        self.setupSelectDate()
        labelNoData.isHidden = true
        //callHomePageAPI()
        
    }
    // MARK: Home page APi Call--
    ///create function for checking the user type for login
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        datetextField.text = ""
        searchbarTextfield.text = ""
        callHomePageAPI()
        if userToken != DefaultValue.emptyString.rawValue && userToken != nil{
            viewLoginSignup.isHidden = true
            loginSignUpButton.isHidden = true
        }else{
            
            viewLoginSignup.isHidden = false
            loginSignUpButton.isHidden = false
        }
    }
    // MARK: view More Button Action--
    // Create Function For navigate to eventCategory Screen.
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func viewMoreActioButton(_ sender: Any) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: EventCategoryListViewController.identifier) as! EventCategoryListViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    
    // MARK: Subscribe Button Action--
    //     Create Function For save the detail of subscribe user
    //     - Parameter sender: UIButton
    // return : nil
    @IBAction func suscribeButtonAction(_ sender: UIButton) {
        fsgHomeViewModel.CallSubscribeApi(email: subscribeTextField.text ?? DefaultValue.emptyString.rawValue) { [weak self] subscribeUserEmail, isSuccess in
            if isSuccess == true{
                self?.showSimpleAlert(message: subscribeUserEmail?.message ?? DefaultValue.errorMsg.rawValue)
                self?.subscribeTextField.text = ""
            }else{
                self?.showSimpleAlert(message: subscribeUserEmail?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: About us Button Action--
    // Create Function For navigate to contact us Screen
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func aboutUsAction(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: AboutUsViewController.identifier) as! AboutUsViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    
    // MARK: Contact us Button Action--
    // Create Function For navigate to contact us screen
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func contactUsAction(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: ContactUsViewController.identifier) as! ContactUsViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    // MARK: Privacy policy Button Action--
    // Create Function For navigate to privacy policy Screen
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func privacyPolicyAction(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: PrivacyPolicyViewController.identifier) as! PrivacyPolicyViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    // MARK: Terms and Condition Button Action--
    // Create Function For navigate to terms & Condition Screen
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func termsAndCondtionAction(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: TermsConditionViewController.identifier) as! TermsConditionViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    // MARK: Open Side menu Action--
    // Create Function For open side menu
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func sideMenuButton(_ sender: UIButton) {
        self.present((Common.shared.setMenu()),animated: true
        )
    }
    // MARK: change the status bar Color--
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Navigate To Login Controller--
    // Create Function For navigate to login screen
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func loginSignUpButtonAction(_ sender: UIButton) {
        AppDelegate.sharedInstance.showLogin()
        
    }
    // MARK: HomePage APi Call--
    // Create Function For Calling Home Page Api
    // - Parameter sender: UIButton
    // return : nil
    func callHomePageAPI(){
        fsgHomeViewModel.CallHomeApi(completition: {[unowned self] responceData, status in
            self.homeData = responceData
            self.pageControl.numberOfPages = self.homeData?.data?.bannerImages?.count ?? 0
          //  self.pageControl.numberOfPages = self.homeData?.data?.banner_images?.count ?? 0
            eventData = self.homeData?.data?.events ?? []
            self.category.removeAll()
            self.category.append(DefaultValue.all.rawValue)
            for categoryname in responceData.data?.categories ?? [] {
                self.category.append(categoryname.name ?? DefaultValue.errorMsg.rawValue)
            }
            self.eventCatagoryCollectionView.reloadData()
            self.collectionViewBanner.reloadData()
            self.popularEvenTableView.reloadData()
            self.collectionViewCategorySelection.reloadData()
        })
    }
    // MARK: create function for calling EventByCategory Api--
    func searchEventByCategoryId(categoryId:Int){
        fsgHomeViewModel.callSearchCategoryApi(id: categoryId) { [weak self]data, isSuccess in
            if isSuccess == true{
                self?.categorydata = data?.data
                if self?.categorydata?.count != nil {
                    self?.labelNoData.isHidden = true
                }else{
                    self?.labelNoData.isHidden = false
                }
                self?.eventCatagoryCollectionView.reloadData()
            }else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.errorMsg.rawValue)
                
            }
        }
    }
}

//
//  AddBannerViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import UIKit

class AddBannerViewController: UIViewController, UIImagePickerControllerDelegate, UINavigationControllerDelegate {
    // MARK: IBOutlets--
    @IBOutlet weak var saveBannerTableview: UITableView!
   // MARK: Variable initializer--
    var saveBannerModel = SaveBannerModel()
    lazy var saveBannerViewModel:SaveBannerViewModel = {
        var saveBannerViewModel = SaveBannerViewModel()
        return saveBannerViewModel
    }()
    var imagePicker: ImagePicker?
    var isSelected = 0
    var bannerDataList = [AddedBannerDataList()]
    var imagePickedIndex = 0
    var mediaData = [Media]()
    var bannerDesp = [AddBanner]()
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        saveBannerTableview.delegate = self
        saveBannerTableview.dataSource = self
        saveBannerTableview.reloadData()
    }
    // MARK: Back Button Action--
    /// Create Function For navigate to previous screen.
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Cancel Button Action--
    /// Create Function For navigate to previous screen
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func cancelButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Save Button Action--
    /// Create Function For save Banner
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func saveBannerAction(_ sender: Any) {
        var isValidationCompleted = true
        for i in 0..<bannerDataList.count{
            if bannerDataList[i].description == "" || bannerDataList[i].description == nil{
                self.showSimpleAlert(message: AppMessage.shared.EnterDescription)
                isValidationCompleted = false
                break
            } else if bannerDataList[i].bannerImagePath == "" || bannerDataList[i].bannerImagePath == nil {
                self.showSimpleAlert(message: AppMessage.shared.SelectImage)
                isValidationCompleted = false
                break
            }
        }
        
        if isValidationCompleted {
            
                saveBannerApiCall()
            
        }
        
        
    }
    // MARK: TextFields Validation--
   /// Create Function For TextField Validation
    func validation()-> String?{
       guard !(String.getString(bannerDataList.first?.description).isEmpty) else{return AppMessage.shared.EnterDescription}
       guard !(String.getString(bannerDataList.first?.bannerImagePath).isEmpty) else{return AppMessage.shared.SelectImage}
       return nil
   }
    // MARK: Create function for calling Add Banner APi--
    func saveBannerApiCall(){
        saveBannerViewModel.callSaveBannerApi(request: bannerDataList) {[weak self] saveBannerData, isSuccess in
            if isSuccess == true{
                self?.refreshAlert(title: Alert.projectName, message: saveBannerData?.message ?? DefaultValue.errorMsg.rawValue)
            }else{
                self?.showSimpleAlert(message: saveBannerData?.message ??  DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Add Button Action--
    ///Create action for delete specific cell for tableView
    /// - Parameter sender: UIButton
    /// /// return : nil
    @objc func addActionButton(sender: UIButton) {
        switch sender.tag {
        case 0:
            increaseCount(indexPath: sender.tag)
        default:
            decreaseCount(index: sender.tag)
        }
    }
    // MARK: Create function for increase cell--
    func increaseCount(indexPath:Int){
        if  bannerDataList.count < 4 {
            bannerDataList.append(AddedBannerDataList())
        }
        saveBannerTableview.reloadData()
    }
    // MARK: Create function for decrease cell--
    func decreaseCount(index: Int){
        if bannerDataList.count > 1{
            bannerDataList.remove(at: index)
        }
        saveBannerTableview.reloadData()
    }
}
    // MARK: Create extension for calling delegate and datasource--
extension AddBannerViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return bannerDataList.count
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: AddBannerTableViewCell.identifier) as! AddBannerTableViewCell
        cell.getText = { [weak self] descpText in
            self?.bannerDataList[indexPath.row].description = descpText
        }
        cell.backCall =  { [weak self] indexvalue in
            self?.pickImage(index: indexPath.row, cell: cell)
        }
        cell.descriptionTextView.text = bannerDataList[indexPath.row].description
        cell.imageTextfield.text = bannerDataList[indexPath.row].bannerImagePath
        if indexPath.row == 0 {
            cell.addCellButton.setImage(UIImage(systemName: DefaultValue.plusImage.rawValue), for: .normal)
        } else {
            cell.addCellButton.setImage(UIImage(systemName: DefaultValue.minusImage.rawValue ), for: .normal)
        }
        cell.addCellButton.tag = indexPath.row
        cell.addCellButton.addTarget(self, action: #selector(addActionButton(sender: )), for: .touchUpInside)
        

        return cell
    }
    // MARK: Create function for pick a image from library--
    func pickImage(index: Int, cell: AddBannerTableViewCell) {
        imagePickedIndex = index
       self.saveBannerViewModel.indexPath = index
        self.saveBannerViewModel.cell = cell
        let imagePicker = UIImagePickerController()
        imagePicker.delegate = self
        imagePicker.sourceType = UIImagePickerController.SourceType.photoLibrary
        imagePicker.allowsEditing = false
        self.present(imagePicker, animated: true, completion: nil)
    }
   // MARK: Create function for picked image url data show in textfield--
    func imagePickerController(_ picker: UIImagePickerController, didFinishPickingMediaWithInfo info: [UIImagePickerController.InfoKey : Any]) {
        if let image = info[UIImagePickerController.InfoKey.originalImage] as? UIImage {
            let imageIs = UUID().uuidString
            let imagePath = getDocumentsDirectory().appendingPathComponent(imageIs)
            self.bannerDataList[imagePickedIndex].bannerImage = image
            self.bannerDataList[imagePickedIndex].bannerImagePath = imagePath.absoluteString
            saveBannerTableview.reloadData()
        }
        picker.dismiss(animated: true, completion: nil)
    }
    
    func getDocumentsDirectory() -> URL {
        let paths = FileManager.default.urls(for: .documentDirectory, in: .userDomainMask)
        return paths[0]
    }
}
// MARK: Create sturcture for cell Item--
struct AddBanner {
    var description: [String: String]?
}
struct AddedBannerDataList{
    var description:String?
    var bannerImage:UIImage?
    var bannerImagePath:String?
    
    
}
